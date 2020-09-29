<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorreosMail extends Mailable
{
    use Queueable, SerializesModels;


    public $contrasena;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('cacao.apps.lima@gmail.com')
            ->subject("San Luis:  Credenciales")
            ->view('mail-formato');
    }
}
