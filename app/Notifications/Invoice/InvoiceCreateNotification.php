<?php

namespace App\Notifications\Invoice;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceCreateNotification extends Notification
{
    use Queueable;
    public $invoice;
    public $authUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice,$authUser)
    {
        $this->invoice = $invoice;
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
            'message' => 'A new invoice created',
            'for'     => 'invoice',
            'url'     => "invoices/".$this->invoice->id,
            'data' => $this->invoice->only([
                'id',
                'quotation_id',
                'company_id',
                'invoice_number',
                'expected_delivery',
                'payment_mode',
                'payment_term',
                'payment_partial_mode',
                'next_payment',
                'last_payment',
                'remarks'
            ]),
            'app' => [
                'screens' => ['Sales', 'Invoices', 'InvoiceDetails
                '],
                'id' => $this->invoice->id
            ]
        ];
}
}
