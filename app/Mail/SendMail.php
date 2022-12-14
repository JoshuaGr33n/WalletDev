<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from('info@readerstacks.com')
               ->subject('Mail from readerstacks.com')
               ->view('emails.emailotp',["user"=>"jjjjj","title"=>"Register"]);
    }
}
// call on controller
// Mail::to('joshuaoleru@gmail.com')->send(new SendMail());