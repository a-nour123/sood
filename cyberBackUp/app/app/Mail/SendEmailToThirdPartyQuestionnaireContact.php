<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailToThirdPartyQuestionnaireContact extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $contact;
    protected $note;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $contact, $note = null)
    {
        //
        $this->data = $data;
        $this->contact = $contact;
        $this->note = $note;
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
        $note = $this->note;

        return $this->markdown('admin/content/third_party/assessments/mail', compact('data', 'contact', 'note'));
    }
}
