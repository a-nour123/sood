<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailToQuestionnaireContact extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $contact)
    {
        //
        $this->data = $data;
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;
        $contact = $this->contact;
        return $this->markdown('admin/content/assessments/questionnaires/mail', compact('data', 'contact'));
    }
}
