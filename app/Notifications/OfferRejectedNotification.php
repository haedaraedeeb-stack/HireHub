<?php

namespace App\Notifications;

use App\Models\Offer;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferRejectedNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public Offer $offer, public string $projectTitle)
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Proposal for a Project' . $this->projectTitle)
            ->line('Unfortunately, another freelancer has been selected for this project.')
            ->line('Keep applying for other projects!');
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
