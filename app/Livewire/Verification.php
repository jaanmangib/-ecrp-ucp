<?php

namespace App\Livewire;

use App\Models\RpTestAttempt;
use App\Models\RpTestQuestion;
use App\Models\RpTestAnswer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Verification extends Component
{
    public array $steps = [];
    public int $stepIndex = 0;

    // RP test state
    public array $questions = [];        // [{id,text,answers:[{id,text}]}]
    public int $activeQuestion = 0;      // 0..7
    public array $picked = [];           // questionId => [answerId, answerId]
    public array $failedQuestions = [];  // list of question texts on fail
    public string $nextTestIn = '';      // "4 min" jne
    public bool $testPassed = false;

    public function mount(): void
    {
        $user = Auth::user();

        // Sammud sõltuvad lipust
        $this->steps = $user->requires_rp_test
            ? ['Rollimängu test', 'Discordi ühendamine', 'Steami ühendamine']
            : ['Discordi ühendamine', 'Steami ühendamine'];

        // Kui RP test pole vajalik -> alusta Discord/Steam sammu järgi
        if (!$user->requires_rp_test) {
            $this->stepIndex = $this->discordConnected ? 1 : 0;
            return;
        }

        // Kui RP test läbitud -> Discord/Steam sammu järgi
        if ($user->rp_test_passed) {
            // Discord samm = 1, Steam samm = 2
            $this->stepIndex = $this->discordConnected ? 2 : 1;
            return;
        }

        // Cooldown (näita fail screen)
        if ($user->rp_test_failed_until && now()->lt($user->rp_test_failed_until)) {
            $this->nextTestIn = now()->diffForHumans($user->rp_test_failed_until, [
                'parts' => 2,
                'short' => true,
                'syntax' => Carbon::DIFF_ABSOLUTE,
            ]);
            $this->stepIndex = 0;
            return;
        }

        // Lae 8 küsimust
        $qs = RpTestQuestion::query()
            ->where('active', true)
            ->orderBy('sort_order')
            ->with(['answers:id,question_id,text'])
            ->limit(8)
            ->get(['id', 'text']);

        $this->questions = $qs->map(fn ($q) => [
            'id' => (int) $q->id,
            'text' => (string) $q->text,
            'answers' => $q->answers
                ->map(fn ($a) => ['id' => (int) $a->id, 'text' => (string) $a->text])
                ->values()
                ->all(),
        ])->values()->all();

        $this->stepIndex = 0;
    }

    /* -----------------------------------------------------------------
     | Computed helpers (Blade saab kasutada $this->...)
     | ----------------------------------------------------------------- */

    public function getDiscordConnectedProperty(): bool
    {
        $u = Auth::user();
        return !empty($u?->discord_id);
    }

    public function getSteamConnectedProperty(): bool
    {
        $u = Auth::user();
        return !empty($u?->steam_id64) || !empty($u?->steam_hex);
    }

    public function getAllDoneProperty(): bool
    {
        $u = Auth::user();
        if (!$u) return false;

        $rpOk = $u->requires_rp_test ? (bool) $u->rp_test_passed : true;

        return $rpOk && $this->discordConnected && $this->steamConnected;
    }

    /* -----------------------------------------------------------------
     | RP test actions
     | ----------------------------------------------------------------- */

    public function toggleAnswer(int $questionId, int $answerId): void
    {
        $arr = $this->picked[$questionId] ?? [];

        if (in_array($answerId, $arr, true)) {
            $arr = array_values(array_diff($arr, [$answerId]));
        } else {
            $arr[] = $answerId;
        }

        $this->picked[$questionId] = $arr;
        $this->resetErrorBag('test');
    }

    public function previousQuestion(): void
    {
        $this->activeQuestion = max(0, $this->activeQuestion - 1);
        $this->resetErrorBag('test');
    }

    public function nextQuestion(): void
    {
        $max = max(0, count($this->questions) - 1);
        $this->activeQuestion = min($max, $this->activeQuestion + 1);
        $this->resetErrorBag('test');
    }

    public function submitTest(): void
    {
        $user = Auth::user();

        // cooldown re-check
        if ($user->rp_test_failed_until && now()->lt($user->rp_test_failed_until)) {
            $this->nextTestIn = now()->diffForHumans($user->rp_test_failed_until, [
                'parts' => 2,
                'short' => true,
                'syntax' => Carbon::DIFF_ABSOLUTE,
            ]);
            return;
        }

        if (empty($this->questions)) {
            $this->addError('test', 'Küsimusi ei leitud. Palun proovi hiljem uuesti.');
            return;
        }

        // Kontroll: igale küsimusele peab midagi valima
        foreach ($this->questions as $q) {
            $qid = (int) $q['id'];
            if (empty($this->picked[$qid])) {
                $this->addError('test', 'Vasta kõikidele küsimustele enne lõpetamist.');
                return;
            }
        }

        // Hangi õiged answerid
        $correctMap = RpTestAnswer::query()
            ->whereIn('question_id', array_column($this->questions, 'id'))
            ->get(['id', 'question_id', 'is_correct'])
            ->groupBy('question_id')
            ->map(fn ($rows) => $rows->where('is_correct', true)->pluck('id')->sort()->values()->all());

        $failedIds = [];
        $score = 0;

        foreach ($this->questions as $q) {
            $qid = (int) $q['id'];
            $picked = collect($this->picked[$qid] ?? [])->map(fn ($v) => (int) $v)->sort()->values()->all();
            $correct = $correctMap[$qid] ?? [];

            if ($picked === $correct) {
                $score++;
            } else {
                $failedIds[] = $qid;
            }
        }

        $attempt = RpTestAttempt::create([
            'user_id' => $user->id,
            'submitted_at' => now(),
            'passed' => $score === count($this->questions),
            'score' => $score,
            'failed_question_ids' => $failedIds ?: null,
        ]);

        // salvesta valitud answerid (audit)
        $answerIds = collect($this->picked)->flatten()->unique()->values()->all();
        foreach ($answerIds as $aid) {
            DB::table('rp_test_attempt_answers')->insert([
                'attempt_id' => $attempt->id,
                'answer_id' => $aid,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($attempt->passed) {
            $user->forceFill([
                'rp_test_passed' => true,
                'rp_test_failed_until' => null,
            ])->save();

            $this->testPassed = true;

            // RP done -> järgmine samm: Discord või Steam
            $this->stepIndex = $this->discordConnected ? 2 : 1;
            return;
        }

        // FAIL: 5 min cooldown
        $user->forceFill([
            'rp_test_passed' => false,
            'rp_test_failed_until' => now()->addMinutes(5),
        ])->save();

        $failedTexts = collect($this->questions)
            ->filter(fn ($q) => in_array((int) $q['id'], $failedIds, true))
            ->map(fn ($q) => (string) $q['text'])
            ->values()
            ->all();

        $this->failedQuestions = $failedTexts;
        $this->nextTestIn = now()->diffForHumans($user->rp_test_failed_until, [
            'parts' => 2,
            'short' => true,
            'syntax' => Carbon::DIFF_ABSOLUTE,
        ]);

        $this->picked = [];
        $this->activeQuestion = 0;
        $this->stepIndex = 0;
    }

    public function render()
    {
        return view('livewire.verification')
            ->layout('layouts.app');
    }
}
