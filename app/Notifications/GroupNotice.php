<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GroupNotice extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $datas;

    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public function broadcastType()
    {
        return 'broadcast.message';
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'group' => 'true',
            'offerGroupId' => $this->datas['offerGroupId'],
            'offerGroupTitle' => $this->datas['offerGroupTitle']
        ]);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            'group' => 'true',
            'offerGroupId' => $this->datas['offerGroupId'],
            'offerGroupTitle' => $this->datas['offerGroupTitle']
        ];
    }
}
