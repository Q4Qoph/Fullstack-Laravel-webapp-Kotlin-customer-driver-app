<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class RideRequestNotification extends Notification
{
    use Queueable;

    protected $ride;

    /**
     * Create a new notification instance.
     *
     * @param $ride
     */
    public function __construct($ride)
    {
        $this->ride = $ride;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Store in database and send via broadcast
    }

    /**
     * Store the notification in the database.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'rideId' => $this->ride->id,
            'pickup_point' => $this->ride->pickup_point,
            'dropoff_point' => $this->ride->dropoff_point,
            'number_of_passengers' => $this->ride->number_of_passengers,
            'customer_name' => $this->ride->customer->name,
            'customer_phone' => $this->ride->customer->phone,
        ];
    }

    /**
     * Send the notification via broadcast.
     *
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'rideId' => $this->ride->id,
            'pickup_point' => $this->ride->pickup_point,
            'dropoff_point' => $this->ride->dropoff_point,
            'number_of_passengers' => $this->ride->number_of_passengers,
            'customer_name' => $this->ride->customer->name,
            'customer_phone' => $this->ride->customer->phone,
        ]);
    }
}
