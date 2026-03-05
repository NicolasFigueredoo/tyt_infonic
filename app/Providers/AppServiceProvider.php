<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Logo;
use App\Models\Contacto;
use App\Models\Rede;
use App\Models\Articulo;
use App\Models\Empresa;
use App\Models\Inicio;
use App\Models\Secciones;
use App\Models\Slider;
use Illuminate\Pagination\Paginator;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \URL::forceScheme('https');
      
        
        
        Paginator::useBootstrap();
        $logosheader = Logo::where('seccion', 'header')->first();
        $logosfooter = Logo::where('seccion', 'footer')->first();
        $logosanmat = Logo::where('seccion', 'anmat')->first();
        $logosifra = Logo::where('seccion', 'ifra')->first();
        $logosaaqc = Logo::where('seccion', 'aaqc')->first();



        $empresa = Empresa::first();

        $bannerPrincipal = Slider::where('seccion', 'bannerPrincipal')->orderBy('orden')->get();       



        $contactos = Contacto::where('seccion','=','contacto')->orderBy('orden', 'desc')->get();
        $inicio = Inicio::all();





        if(session('locale') == null){
            session(['locale' => 'es']);

        }

        $redes = Rede::orderbY('orden', 'asc')->get();
        $secciones = Secciones::orderBy('orden', 'asc')->get();

        $articulosList = Articulo::where('oculto','=','false')->get();

        //Collection::mixin(new CollectionMacros());
        view()->share(['secciones'=>$secciones,'empresa'=>$empresa,'inicio'=>$inicio,'bannerPrincipal'=>$bannerPrincipal, 'articulosList'=>$articulosList,'logosheader'=>$logosheader,'logosfooter'=>$logosfooter,'contactos'=>$contactos,'redes'=>$redes, 'logosanmat'=>$logosanmat, 'logosaaqc'=>$logosaaqc, 'logosifra'=>$logosifra]);

        $request = request()->all();
        array_walk_recursive($request, function (&$item, $clave) {
            // el siguiente codigo es para que los campos undefined, null y NULL pero que llegan como string
            // se conviertan en null realmente
            if ($item == 'undefined' || $item == 'null' || $item == 'NULL') {
                $item = null;
            }
            // si el campo es un string y tiene espacios al inicio o al final, se eliminan
            if (is_string($item)) {
                $item = trim($item);
            }
        });
        request()->merge($request);

        // Añade el metodo toRawSql a los query builder
        \Illuminate\Database\Query\Builder::macro('toRawSql', function(){
            return array_reduce($this->getBindings(), function($sql, $binding){
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'" , $sql, 1);
            }, $this->toSql());
        });
        \Illuminate\Database\Eloquent\Builder::macro('toRawSql', function(){
            return ($this->getQuery()->toRawSql());
        });

    }
}
