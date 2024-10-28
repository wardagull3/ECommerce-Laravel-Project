<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    public $type; 

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $type)
    {
        $this->order = $order;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('Order ' . ucfirst($this->type))
            ->line('Your order has been ' . $this->type . ' successfully.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total Price: $' . $this->order->total_price)
            ->line('Status: ' . ucfirst($this->order->status))
            ->action('View Order', url('/customer/orders/' . $this->order->id));

        return $message;
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
            //
        ];
    }
}
