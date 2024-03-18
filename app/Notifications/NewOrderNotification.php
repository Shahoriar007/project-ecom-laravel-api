<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     private Order $order;
     private $authUser;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->authUser = auth()->user();
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'model' => $this->order,
                'message' => "New order! Order Id: {$this->order->id}",
                // 'created_by' => $this->authUser,
                'url' => "admin/orders",
                'icon' => 'BriefcaseIcon',
                'variant' => 'light-success',
                'sub_title' =>  "Total price: {$this->order->total_price}"
        ];
    }
}
