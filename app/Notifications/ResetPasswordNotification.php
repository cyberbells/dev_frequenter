<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;
    public $token;
    public $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
    */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Funcation to Send notification on Mail.
    */
    public function toMail($notifiable)
    {
        $frontendUrl = env('FRONTEND_URL', 'http://127.0.0.1:8000');
        $resetLink = "{$frontendUrl}/reset-password?token={$this->token}&email={$this->email}";
        return (new MailMessage)
            ->subject('Reset Your Password')
            ->line('Click the button below to reset your password.')
            ->action('Reset Password', $resetLink)
            ->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
