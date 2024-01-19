<?php

namespace App\Notifications\DeliveryNote;

use App\Models\DeliveryNote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliveryNoteCreateNotification extends Notification
{
    use Queueable;
    public $deliveryNote;
    public $authUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DeliveryNote $deliveryNote,$authUser)
    {
        info($deliveryNote);
        $this->deliveryNote = $deliveryNote;
        $this->authUser = $authUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return [
            'user' => $this->authUser,
            'message' => 'A new Delivery Note created',
            'for'     => 'deliveryNote',
            'url'     => "delivery-notes/".$this->deliveryNote->id,
            'data' => $this->deliveryNote->only([
                'id',
                'company_id',
                'invoice_id',
                'dn_number',
                'remarks',
                'created_at'
            ])
        ];
    }
}
