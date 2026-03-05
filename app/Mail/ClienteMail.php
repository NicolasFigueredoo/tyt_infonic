<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClienteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $cliente;
    public $file;
    public function __construct($cliente)
    {        
        $this->cliente=$cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = "Pedido N° ".$this->cliente->id;
        $return = $this
            ->subject( $title )
            ->view('emails.ClienteMail')
            ->with( 'cliente',$this->cliente );

        return $return;
    }    

}
