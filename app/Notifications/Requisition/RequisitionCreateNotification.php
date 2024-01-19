<?php

namespace App\Notifications\Requisition;

use App\Models\Requisition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequisitionCreateNotification extends Notification
{
    use Queueable;

    public $requisition;
    public $authUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Requisition $requisition, $authUser)
    {

        $this->requisition = $requisition;
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
            'message' => 'A new requisition created',
            'for'     => 'requisition',
            'url'     => "requisitions/".$this->requisition->id,
            'data' => $this->requisition->only([
                'id',
                'company_id',
                'engineer_id',
                'priority',
                'type',
                'payment_mode',
                'expected_delivery',
                'payment_term',
                'payment_partial_mode',
                'partial_time',
                'next_payment',
                'ref_number',
                'machine_problems',
                'solutions',
                'reason_of_trouble',
                'rq_number',
                'status',
                'remarks'
            ]),
            'app' => [
                'screens' => ['Sales', 'Requisitions', 'RequisitionDetails'],
                'id' => $this->requisition->id
            ]
        ];
    }
}
