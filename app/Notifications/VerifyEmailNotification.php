<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Eclipse RP – Kinnita oma e-post')
            ->greeting('Tere!')
            ->line('Enne jätkamist palun kinnita oma e-posti aadress.')
            ->action('Kinnita e-post', $this->verificationUrl($notifiable))
            ->line('Kui sa ei loonud Eclipse RP kontot, võid selle kirja ignoreerida.')
            ->salutation('Eclipse RP tiim');
    }
}
