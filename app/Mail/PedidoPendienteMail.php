<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoPendienteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;
    public $lapso; // 24 o 48

    /**
     * Create a new message instance.
     *
     * @param  mixed  $cliente
     * @param  int  $lapso
     * @return void
     */
    public function __construct($cliente, $lapso)
    {
         $this->cliente = $cliente;
         $this->lapso = $lapso;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject("Tienes un pedido pendiente por completar")
                     ->view('emails.PedidoPendiente')
                     ->with([
                         'cliente' => $this->cliente,
                         'lapso'   => $this->lapso,
                     ]);
    }
}
