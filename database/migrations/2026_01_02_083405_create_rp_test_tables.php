<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rp_test_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('text');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('rp_test_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('rp_test_questions')->cascadeOnDelete();
            $table->text('text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('rp_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('passed')->default(false);
            $table->unsignedTinyInteger('score')->default(0); // mitu küsimust õigesti
            $table->json('failed_question_ids')->nullable();  // [1,5,7] jne
            $table->timestamps();
        });

        Schema::create('rp_test_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('rp_test_attempts')->cascadeOnDelete();
            $table->foreignId('answer_id')->constrained('rp_test_answers')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['attempt_id', 'answer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rp_test_attempt_answers');
        Schema::dropIfExists('rp_test_attempts');
        Schema::dropIfExists('rp_test_answers');
        Schema::dropIfExists('rp_test_questions');
    }
};
