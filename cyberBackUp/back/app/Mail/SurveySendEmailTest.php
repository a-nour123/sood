<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveySendEmailTest extends Mailable
{
    use Queueable, SerializesModels;


    protected $survey;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($survey)
    {
        $this->survey = $survey;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $survey = $this->survey;
        return $this->markdown('mail.survey-send-mail', compact('survey'));
    }
}
