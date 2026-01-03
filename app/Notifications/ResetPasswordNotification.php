<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public function __construct(
        protected string $token
    ) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Eclipse RP – Parooli taastamine')
            ->greeting('Tere!')
            ->line('Saime parooli taastamise taotluse sinu kontole.')
            ->action('Taasta parool', $url)
            ->line('See link aegub 60 minuti pärast.')
            ->line('Kui sina ei taotlenud parooli taastamist, võid selle kirja ignoreerida.')
            ->salutation('Eclipse RP tiim');
    }
}
