<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class CreateEmail extends Mailable
{

    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Booking Confirmation')
            ->view('emails.example')
            ->with([
                'booking' => $this->booking,
            ]);
    }

}
