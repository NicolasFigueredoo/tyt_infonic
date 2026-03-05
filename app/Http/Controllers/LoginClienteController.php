<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

use App\Models\Cliente;

use App\Models\Logo;

use App\Models\TipoArticulo;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

use App\Models\Contacto;

use App\Mail\ActivarCuenta;

use Illuminate\Support\Facades\Mail;

use GuzzleHttp\Client;

use GuzzleHttp\RequestOptions;

use App\Mail\ClienteMail;

use App\Models\ClienteRegistro;

use App\Models\Inicio;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Http;



class LoginClienteController extends Controller

{

    use AuthenticatesUsers;



    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    //Cambiar ruta a donde se va a logear el cliente

    protected $redirectTo = '/';



    /**

     * Create a new controller instance.

     *

     * @return void

     */



    public function email()

    {

        return 'email';
    }



    public function __construct()

    {

        //$this->middleware('auth.cliente')->except('logout');

    }



    public function login(Request $request)

    {



        $request->session()->forget('obj_fila');



        // $this->validateLogin($request);



        // if ($this->hasTooManyLoginAttempts($request)) {

        //     $this->fireLockoutEvent($request);

        //     return $this->sendLockoutResponse($request);

        // }



        $cliente = Cliente::where('email', '=', $request->username)->first();







        if ($cliente && Hash::check($request->password, $cliente->password)) {



            $current_time = time();

            $flag = 1;

            $tiempo = strtotime($cliente->tiempo . "+1 day");



            if ($cliente->temporal == 1 && $tiempo <= $current_time) {

                $flag = 0;

                $cliente->estado = 1;

                $cliente->save();

                $this->incrementLoginAttempts($request);

                return back()->withErrors(['msj' => "Tiempo de cuenta vencido"]);
            }



            if ($flag === 1) {

                Auth::guard('cliente')->loginUsingId($cliente->id);

                if (Auth::guard('cliente')->user()->estado == 1) {

                    return redirect()->route('page.productosCategorias');
                } else {

                    Auth::guard('cliente')->logout();

                    return back()->withErrors(['msj' => "Datos incorrectos"]);
                }
            }
        } else {

            $this->incrementLoginAttempts($request);



            return back()->withErrors(['msj' => "Datos incorrectos"]);
        }
    }

    public function salir(Request $request)

    {

        Auth::guard('cliente')->logout();

        return redirect()->route('page.inicio');
    }



    /**

     * Validate the user login request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return void

     *

     * @throws \Illuminate\Validation\ValidationException

     */

    protected function validateLogin(Request $request)

    {

        $request->validate([

            $this->email() => 'required|string',

            'password' => 'required|string',

        ]);
    }



    /**

     * Attempt to log the user into the application.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return bool

     */

    protected function attemptLogin(Request $request)

    {

        return $this->guard('cliente')->attempt(

            $this->credentials($request),

            $request->filled('remember')

        );
    }



    /**

     * Get the needed authorization credentials from the request.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return array

     */

    protected function credentials(Request $request)

    {

        return $request->only($this->email(), 'password');
    }



    /**

     * Send the response after the user was authenticated.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse

     */

    protected function sendLoginResponse(Request $request)

    {

        $request->session()->regenerate();



        $this->clearLoginAttempts($request);



        if ($response = $this->authenticated($request, $this->guard('cliente')->user())) {

            return $response;
        }



        return $request->wantsJson()

            ? new JsonResponse([], 204)

            : redirect()->intended($this->redirectPath());
    }



    /**

     * The user has been authenticated.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  mixed  $user

     * @return mixed

     */

    protected function authenticated(Request $request, $user)

    {

        //

    }



    /**

     * Get the failed login response instance.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Symfony\Component\HttpFoundation\Response

     *

     * @throws \Illuminate\Validation\ValidationException

     */

    protected function sendFailedLoginResponse(Request $request)

    {

        throw ValidationException::withMessages([

            $this->email() => [trans('auth.failed')],

        ]);
    }



    /**

     * Get the login username to be used by the controller.

     *

     * @return string

     */



    /**

     * Log the user out of the application.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse

     */

    public function logout(Request $request)

    {

        $this->guard('cliente')->logout();



        $request->session()->invalidate();



        $request->session()->regenerateToken();



        if ($response = $this->loggedOut($request)) {

            return $response;
        }



        return $request->wantsJson()

            ? new JsonResponse([], 204)

            : redirect('/');
    }



    /**

     * The user has logged out of the application.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return mixed

     */

    protected function loggedOut(Request $request)

    {

        //

    }



    /**

     * Get the guard to be used during authentication.

     *

     * @return \Illuminate\Contracts\Auth\StatefulGuard

     */

    protected function guard()

    {

        return Auth::guard('cliente');
    }



    protected function registro_cliente()
    {
        $active  = 'page.registro';
        $inicio  = Inicio::first();
        $camposDinamicos = \DB::table('form_campos')->where('activo', 1)->orderBy('orden')->get();

        return view('page.registro', compact('active', 'inicio', 'camposDinamicos'));
    }



    public function registro_cliente_post(Request $request)
    {
        \Log::info('registro_cliente_post inicio', ['data' => $request->except('g-recaptcha-response')]);

        // reCAPTCHA
        $request->validate(['g-recaptcha-response' => 'required']);
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        try {
            $recaptchaVerifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secretKey,
                'response' => $recaptchaResponse,
                'remoteip' => $request->ip(),
            ]);
            $recaptchaData = $recaptchaVerifyResponse->json();
            if (!$recaptchaData['success'] || $recaptchaData['score'] < 0.5) {
                return redirect()->back()->withErrors(['captcha' => 'La validación del captcha falló. Inténtalo nuevamente.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['captcha' => 'Hubo un error al verificar el reCAPTCHA. Inténtalo más tarde.']);
        }

        // Cargar campos dinámicos activos
        $camposDinamicos = \DB::table('form_campos')->where('activo', 1)->orderBy('orden')->get();

        // Validar requeridos
        $rules = [];
        foreach ($camposDinamicos as $campo) {
            if ($campo->requerido) {
                $rules['campo_' . $campo->id] = 'required';
            }
        }
        $request->validate($rules);

        try {
            $user          = new ClienteRegistro();
            $user->estado  = 0;
            $user->cuenta  = $this->generateUniqueCuenta();

            // Columnas permitidas para asignación dinámica
            $columnasPermitidas = [
                'empresa',
                'razonSocial',
                'nombre',
                'apellido',
                'nombreEmpresa',
                'email',
                'cuit',
                'dni',
                'telefono',
                'iva',
                'direccion',
                'numero',
                'localidad',
                'provincia',
                'cp',
                'transporte',
                'direccionEntrega',
                'numeroEntrega',
                'localidadEntrega',
                'provinciaEntrega',
                'cpEntrega',
            ];

            // Mapear campos vinculados a columnas del modelo
            foreach ($camposDinamicos as $campo) {
                if (!$campo->campo_sistema) continue;
                if (!in_array($campo->campo_sistema, $columnasPermitidas)) continue;

                $key   = 'campo_' . $campo->id;
                $valor = $request->input($key);

                if ($valor === '__otro__') {
                    $valor = $request->input('campo_otro_' . $campo->id, 'Otro');
                }
                if ($campo->tipo === 'checkbox' && is_array($valor)) {
                    $valor = json_encode($valor);
                }

                $columna        = $campo->campo_sistema;
                $user->$columna = $valor;
            }

            $user->save();

            // Guardar todos los campos en form_respuestas + detalle
            $respuestaId = \DB::table('form_respuestas')->insertGetId([
                'cliente_registro_id' => $user->id,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            $detallesGuardados = []; // para reusar en el email

            foreach ($camposDinamicos as $campo) {
                $key   = 'campo_' . $campo->id;
                $valor = null;

                if ($campo->tipo === 'file') {
                    if ($request->hasFile($key)) {
                        $valor = $request->file($key)->store('form_respuestas', 'public');
                    }
                } elseif (in_array($campo->tipo, ['checkbox', 'image_choice'])) {
                    $valor = $request->filled($key) ? json_encode($request->input($key)) : null;
                } else {
                    $valor = $request->input($key);
                    if ($valor === '__otro__') {
                        $valor = $request->input('campo_otro_' . $campo->id, 'Otro');
                    }
                }

                \DB::table('form_respuestas_detalle')->insert([
                    'respuesta_id' => $respuestaId,
                    'campo_id'     => $campo->id,
                    'valor'        => $valor,
                    'created_at'   => now(),
                ]);

                $detallesGuardados[$campo->id] = $valor;
            }

            // Construir array de campos para el email
            $camposEmail = [];
            foreach ($camposDinamicos as $campo) {
                $valor      = $detallesGuardados[$campo->id] ?? null;
                $valorArray = [];

                if (in_array($campo->tipo, ['checkbox', 'image_choice'])) {
                    $valorArray = $valor ? json_decode($valor, true) ?? [] : [];
                }

                $camposEmail[] = [
                    'label'       => $campo->label,
                    'tipo'        => $campo->tipo,
                    'valor'       => $valor,
                    'valor_array' => $valorArray,
                    'opciones'    => $campo->opciones ? json_decode($campo->opciones, true) : [],
                ];
            }

            // Enviar emails
            $email = new ActivarCuenta($user, $camposEmail);
            Mail::to('info@tytsa.com.ar')->send($email);
            Mail::to('dcamacho.tytsa@gmail.com')->send($email);
            Mail::to('lmorales.tytsa@gmail.com')->send($email);
            Mail::to('ariel@tytsa.com.ar')->send($email);

            $active = "";
            $inicio = Inicio::first();
            return view('page.activarCuenta', compact('active', 'inicio'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->withErrors(['error' => 'No se pudo crear el cliente. Intente nuevamente.']);
        }
    }
























    private function generateUniqueCuenta()

    {

        do {

            // Genera un número aleatorio de 8 dígitos

            $cuenta = $this->generateRandomNumber(6);
        } while (Cliente::where('cuenta', $cuenta)->exists()); // Verifica que no esté en uso



        return $cuenta;
    }



    private function generateRandomNumber($length)

    {

        // Genera un número aleatorio dentro del rango de 0 hasta 10^$length - 1

        // Luego se asegura de que el número tenga la longitud deseada

        $maxValue = pow(10, $length) - 1;

        $number = mt_rand(0, $maxValue); // Genera un número aleatorio en el rango



        return str_pad($number, $length, '0', STR_PAD_LEFT); // Asegura que tenga el largo especificado, completando con ceros a la izquierda

    }





    protected function updateClient(Request $request)

    {

        $user = Cliente::find($request->id);



        // Validación del email

        $request->validate([

            'email' => 'required|unique:clientes,email,' . $user->id,

        ]);



        try {

            // Asignación de los datos del formulario al usuario

            $user->empresa = $request->empresa;

            if ($request->password) {

                $user->password = Hash::make($request->password);
            }

            if ($request->email) {

                $user->email = $request->email;
            }

            $user->cuit = $request->cuit;

            $user->iva = $request->iva;

            $user->direccion = $request->direccion;

            $user->direccionEntrega = $request->direccionEntrega;

            $user->transporte = $request->transporte;

            $user->cp = $request->cp;

            $user->provincia = $request->provincia;

            $user->localidad = $request->localidad;

            $user->telefono = $request->celular;

            $user->apellido = $request->apellido;

            $user->nombre = $request->nombre;

            $user->estado = 1;



            // Guardado de los datos

            $user->save();



            // Mensaje de éxito para la vista

            $mensajeForm = 'Datos guardados correctamente.';
        } catch (\Exception $e) {

            // Mensaje de error para la vista en caso de excepción

            $mensajeForm = 'Ocurrió un error al guardar los datos: ' . $e->getMessage();
        }



        // Variables para la vista

        $active = "";

        $inicio = Inicio::first();



        return view('ZonaPrivada.miperfil', compact('active', 'user', 'inicio', 'mensajeForm'));
    }
}
