<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivarCuenta extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $camposForm; // array de {label, tipo, valor, valor_array, opciones}

    public function __construct($user, $camposForm = [])
    {
        $this->user       = $user;
        $this->camposForm = $camposForm;
    }

    public function build()
    {
        return $this
            ->subject('Activa tu cuenta TyT')
            ->view('emails.ActivarCuenta');
    }
}