<?php
/** 
 * Livewire User Component
 * 
 * PHP version 7.4
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Notifications;

use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
/**
 *  Livewire Users component
 * 
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class UserUpdate extends Notification
{
    use Queueable;
    public $field;

    /**
     * Create a new notification instance.
     * 
     * @param $myfields my role
     *
     * @return void
     */
    public function __construct($myfields)
    {
        $this->field = $myfields;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable notifiable
     * 
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable notification
     * 
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        //dd($this->field);
        $message = '';
        
        foreach ($this->field as $key => $value) {
            $message = $message.$key.' ';
            if (strcmp($value, 'password')!=0) {
                $message = $message.': '.$value.' ';
            } else {
                $message = $message.': updated ';
            }
            $message = $message.', ';
        }
        
        
        //dd($this->field);
        return (new MailMessage)
            ->subject('Profile update notification')
            ->greeting('Hi '.$notifiable->name) 
            ->line('The following fields of your profile have been updated.')
            ->line($message)
            ->line('If you did not do it, please contact the system administrator.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable notification
     * 
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
