<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordReset extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token = $token;
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
        /*
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
        */

        
        return (new MailMessage)
        ->from('noreply.mailer.omnipool.co@gmail.com')
        ->subject('Omnipool.co Password Reset')
        ->line('You are receiving this email because we received a password reset request for your account.') // Here are the lines you can safely override
        ->action('Reset Password', url('password/reset', $this->token))
        ->line('If you did not request a password reset, no further action is required.');
                
        //return (new MailMessage)->markdown('mail.test.message');
        /*
        $url = url('password/reset');
        //$token

        return (new MailMessage)
                ->subject('SRI Password Reset')
                ->markdown('mail.test.message', ['url' => $url]);
        
        $link = url( "/password/reset/?token=" . $this->token );
        */
       /*
       return ( new MailMessage )
          ->view('reset.emailer')
          ->from('info@example.com')
          ->subject( 'Reset your password' )
          ->line( "Hey, We've successfully changed the text " )
          ->action( 'Reset Password', $link )
          ->attach('reset.attachment')
          ->line( 'Thank you!' );
        */

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

