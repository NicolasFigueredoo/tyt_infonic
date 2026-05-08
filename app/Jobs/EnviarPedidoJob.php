<?php

namespace App\Jobs;

use App\Mail\Carrito;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EnviarPedidoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pedido_carrito;
    protected $file;
    protected $usuario;

    public $tries = 3;
    public $timeout = 120;

    public function __construct($pedido_carrito, $file, $usuario)
    {
        $this->pedido_carrito = $pedido_carrito;
        $this->file = $file;
        $this->usuario = $usuario;
    }

    public function handle()
    {
        Log::info('=== EnviarPedidoJob INICIO ===', [
            'pedido_id' => is_array($this->pedido_carrito)
                ? ($this->pedido_carrito['id'] ?? null)
                : ($this->pedido_carrito->id ?? null),

            'numeroPedido' => is_array($this->pedido_carrito)
                ? ($this->pedido_carrito['numeroPedido'] ?? null)
                : ($this->pedido_carrito->numeroPedido ?? null),

            'usuario_email' => is_array($this->usuario)
                ? ($this->usuario['email'] ?? null)
                : ($this->usuario->email ?? null),

            'file_type' => gettype($this->file),
            'queue_connection' => config('queue.default'),
            'mailer' => config('mail.default'),
            'mail_from' => config('mail.from.address'),
        ]);

        $usuarioEmail = is_array($this->usuario)
            ? ($this->usuario['email'] ?? null)
            : ($this->usuario->email ?? null);

        $destinatarios = array_filter([
            $usuarioEmail,
            'info@tytsa.com.ar',
            'dcamacho.tytsa@gmail.com',
            'lmorales.tytsa@gmail.com',
            'ariel@tytsa.com.ar',
        ]);

        foreach ($destinatarios as $destinatario) {
            Log::info('EnviarPedidoJob: enviando mail', [
                'destinatario' => $destinatario,
            ]);

            Mail::to($destinatario)->send(
                new Carrito($this->pedido_carrito, $this->file, $this->usuario)
            );

            Log::info('EnviarPedidoJob: mail enviado OK', [
                'destinatario' => $destinatario,
            ]);
        }

        Log::info('=== EnviarPedidoJob FIN OK ===', [
            'destinatarios' => $destinatarios,
        ]);
    }

    public function failed(Throwable $exception)
    {
        Log::error('=== EnviarPedidoJob FALLÓ DEFINITIVAMENTE ===', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),

            'pedido_id' => is_array($this->pedido_carrito)
                ? ($this->pedido_carrito['id'] ?? null)
                : ($this->pedido_carrito->id ?? null),

            'numeroPedido' => is_array($this->pedido_carrito)
                ? ($this->pedido_carrito['numeroPedido'] ?? null)
                : ($this->pedido_carrito->numeroPedido ?? null),

            'usuario_email' => is_array($this->usuario)
                ? ($this->usuario['email'] ?? null)
                : ($this->usuario->email ?? null),
        ]);
    }
}