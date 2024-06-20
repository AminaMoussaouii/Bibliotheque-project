<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmpruntEnRetardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nom;
    public $prénom;

    /**
     * Create a new message instance.
     *
     * @param array $details
     */
    public function __construct($details)
    {
        $this->nom = $details['nom'];
        $this->prénom = $details['prénom'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rappel pour le retour de livre en retard')
                    ->view('emails.retard');
    }
}
