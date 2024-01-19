<?php

namespace App\Notifications\Requisition;

use App\Models\RequiredPartRequisition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequiredRequisitionNotification extends Notification
{
    use Queueable;

    public $reqired_requisition;
    public $authUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RequiredPartRequisition $reqired_requisition, $authUser)
    {
        $this->reqired_requisition = $reqired_requisition;
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
        // return ['mail'];
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
            'message' => 'A new required requisition created',
            'for'     => 'required_requisition',
            'url'     => "require_req/".$this->reqired_requisition->id,
            'data' => $this->reqired_requisition->only([
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
                'screens' => ['Sales', 'RequiredRequisitions', 'RequiredRequisitionDetails'],
                'id' => $this->reqired_requisition->id
            ]
        ];
    }
}
