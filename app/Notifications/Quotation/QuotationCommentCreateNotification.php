<?php

namespace App\Notifications\Quotation;

use App\Models\QuotationComment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuotationCommentCreateNotification extends Notification
{
    use Queueable;
    public $quotationComment;
    public $authUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(QuotationComment $quotationComment, $authUser)
    {
        $this->quotationComment = $quotationComment;
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
            'message' => 'A new Quotation Comment created',
            'for'     => 'quotationComment',
            'url'     => 'quotations/'.$this->quotationComment->quotation_id,
            'data' => $this->quotationComment->only([
                'id','quotation_id','sender_id','text','type','remarks'
            ]),
            'app' => [
                'screens' => ['Sales', 'Quotations', 'QuotationComment'],
                'id' => $this->quotationComment->quotation_id
            ]
        ];
    }
}
