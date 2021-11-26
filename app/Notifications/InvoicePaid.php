<?php

namespace App\Notifications;

use App\Models\Group;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class InvoicePaid extends Notification
{
    use Queueable;
    public $datas;

    public $with = ['group'];

    public function offerGroup()
    {
        $id = $this->datas['offerGroup'];
        return Group::find($id);
    }


    public function offerUser()
    {
        $id = $this->datas['offerUser'];
        return User::find($id);
    }
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        $this->datas = $datas;
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
    public function broadcastType()
    {
        return 'broadcast.message';
    }
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => 'hellow'
        ]);
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
            'offerUser' => $this->offerUser(),
            'offerGroup' => $this->offerGroup()

        ];
    }
}
