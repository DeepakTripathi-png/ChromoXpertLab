<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $appointmentDetails;

    /**
     * Create a new message instance.
     *
     * @param Appointment $appointmentDetails
     */
    public function __construct(Appointment $appointmentDetails)
    {
        $this->appointmentDetails = $appointmentDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Confirmation')
                    ->view('Admin.emails.appointment_confirmation')
                    ->with(['appointment' => $this->appointmentDetails]);
    }
}