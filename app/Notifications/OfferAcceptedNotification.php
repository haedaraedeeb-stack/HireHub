<?php

namespace App\Notifications;

use App\Models\Offer;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfferAcceptedNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct
    (public Offer $offer , public string $projectTitle
    )
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
            ->subject('Your offer has been accepted!')
            ->line('Your offer for the project has been accepted:' . $this->projectTitle)
            ->line('Agreed Amount:' . $this->offer->price . ' USD')
            ->action('Watch the Offer', url('/offers/' . $this->offer->id));
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
