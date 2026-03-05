<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Carrito extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido_carrito;
    public $file;
    public $usuario;

    public function __construct($pedido_carrito, $file, $usuario)
    {
        $this->pedido_carrito = (object) $pedido_carrito;
        $this->file = $file;
        $this->usuario = (object) $usuario;
    }

    public function build()
    {
        // Corregido: Usar $this->pedido_carrito para acceder a la propiedad
        Log::info('Pedido Carrito:', ['pedido_carrito' => $this->pedido_carrito]);
        Log::info('Pedido Carrito:', ['usuario' => $this->usuario]);

        // No es necesario volver a convertirlo en objeto
        // $this->pedido_carrito = (object) $this->pedido_carrito;  
        // $this->usuario = (object) $this->usuario;

        // Corregido: Acceder correctamente al ID del pedido
        $title = "Pedido N° ".$this->pedido_carrito->id;

        $return = $this
            ->subject($title)
            ->view('emails.Carrito')
            ->with([
                'pedido_carrito' => $this->pedido_carrito,
                'usuario' => $this->usuario,  
            ]);

        if (!empty($this->file)) {
            $return = $return->attach($this->file->getRealPath(), [
                'as' => $this->file->getClientOriginalName(),
                'mime' => $this->file->getClientMimeType(),
            ]);
        }

        return $return;
    }
}
