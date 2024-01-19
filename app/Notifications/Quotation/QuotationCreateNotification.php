<?php

namespace App\Notifications\Quotation;

use App\Models\Quotation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuotationCreateNotification extends Notification
{
    use Queueable;

    public $quotation;
    public $authUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Quotation $quotation, $authUser)
    {
        $this->quotation = $quotation;
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
            'message' => 'A new quotation created',
            'for'     => 'quotation',
            'url'     => "quotations/".$this->quotation->id,
            'data' => $this->quotation->only([
                'id','requisition_id','company_id','pq_number','locked_at','expriation_date','remarks'
            ]),
            'app' => [
                'screens' => ['Sales', 'Quotations', 'QuotationDetails'],
                'id' => $this->quotation->id
            ]
        ];

    }
}
