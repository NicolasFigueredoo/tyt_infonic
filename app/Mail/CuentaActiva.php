<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CuentaActiva extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $cliente;
    public $nuevaContrasena;
    public function __construct($cliente, $nuevaContrasena)
    {
        $this->cliente = $cliente;
        $this->nuevaContrasena = $nuevaContrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = "Tu cuenta esta activada";
        $return = $this
            ->subject($title)
            ->with([
                'email' => $this->cliente->email,
                'nuevaContrasena' => $this->nuevaContrasena,
            ])
            ->view('emails.CuentaActiva');


        return $return;
    }
}
