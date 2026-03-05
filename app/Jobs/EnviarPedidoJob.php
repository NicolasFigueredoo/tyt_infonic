namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\Carrito;
use Illuminate\Support\Facades\Log;

class EnviarPedidoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pedido_carrito;
    protected $file;
    protected $usuario;

    public function __construct($pedido_carrito, $file, $usuario)
    {
        $this->pedido_carrito = $pedido_carrito;
        $this->file = $file;
        $this->usuario = $usuario;
    }

    public function handle()
    {
        try {
            $email = new Carrito($this->pedido_carrito, $this->file, $this->usuario);

            Mail::to($this->usuario->email)->send($email);
            Mail::to('info@tytsa.com.ar')->send($email);
            Mail::to('dcamacho.tytsa@gmail.com')->send($email);
            Mail::to('lmorales.tytsa@gmail.com')->send($email);
            Mail::to('ariel@tytsa.com.ar')->send($email);
            Mail::to('nicolasfigueredo_02@hotmail.com')->send($email);

            Log::info('Pedido enviado correctamente al correo.');
        } catch (\Exception $e) {
            Log::error('Error al enviar correo en el job EnviarPedidoJob: ' . $e->getMessage());
        }
    }
}
