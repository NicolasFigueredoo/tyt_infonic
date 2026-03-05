<?php



use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Str;

use App\Models\User;

use App\Models\AsisRentasSync;

use Junges\ACL\Models\Permission;

use Junges\ACL\Models\Group;

use App\Http\Controllers\Admin\PermissionController;

use App\Http\Controllers\Admin\GroupController;

use App\Http\Controllers\Admin\ClienteController;

use App\Http\Controllers\Admin\ArticuloController;

use App\Http\Controllers\Admin\InformacionTecnicaController;

use App\Http\Controllers\Admin\TipoArticuloController;

use App\Http\Controllers\Admin\StockController;

use App\Http\Controllers\Admin\UploadController;



use App\Http\Controllers\Admin\InicioController;

use App\Http\Controllers\Admin\EmpresaController;

use App\Http\Controllers\Admin\CalidadController;

use App\Http\Controllers\Admin\ClientePotencialController;

use App\Http\Controllers\Admin\NovedadCategoriaController;

use App\Http\Controllers\Admin\NovedadController;

use App\Http\Controllers\Admin\ContactoController;

use App\Http\Controllers\Admin\LogoController;

use App\Http\Controllers\Admin\RedesController;

use App\Http\Controllers\Admin\MetadatosController;

use App\Http\Controllers\Admin\VendedoresController;

use App\Http\Controllers\Admin\ComoComprarController;

use App\Http\Controllers\Admin\DescargaController;

use App\Http\Controllers\Admin\FamiliaController;

use App\Http\Controllers\Admin\MetricasController;

use App\Http\Controllers\Admin\PedidoController;

use App\Http\Controllers\Admin\SeccionesController;

use App\Http\Controllers\Admin\TutorialesController;

use App\Http\Controllers\Admin\SubCategoriaController;
use App\Http\Controllers\Admin\FormularioClienteController;

Route::group(['middleware' => ['auth']], function () {

    Route::group([

        'prefix' => 'upload',

        'as'     => 'upload',

    ], function() {

        Route::post('/store',  [UploadController::class, 'store']);

    });

    

    Route::group([

        'prefix' => 'inicio',

        'as'     => 'inicio.',

    ], function() {

        Route::post('/',             [InicioController::class, 'all'])->name('all');

        Route::get ('/{id}',         [InicioController::class, 'find'])->name('find');

        Route::post('/store/{id?}',  [InicioController::class, 'store'])->name('store');

        Route::get ('/delete/{id}',  [InicioController::class, 'delete'])->name('delete');

        Route::get ('/restore/{id}', [InicioController::class, 'restore'])->name('restore');

        Route::post('/list-select',  [InicioController::class, 'listSelect'])->name('list-select');

        Route::post('/slider',             [InicioController::class, 'allSlider'])->name('slider.all');

        Route::get ('/slider/{id}',         [InicioController::class, 'findSlider'])->name('slider.find');

        Route::post('/slider/store/{id?}',  [InicioController::class, 'storeSlider'])->name('slider.store');

        Route::get ('/slider/delete/{id}',  [InicioController::class, 'deleteSlider'])->name('slider.delete');

        Route::get ('/slider/restore/{id}', [InicioController::class, 'restoreSlider'])->name('slider.restore');

        Route::post('/logos',             [InicioController::class, 'allLogos'])->name('logos.all');

        Route::get ('/logos/{id}',         [InicioController::class, 'findLogos'])->name('logos.find');

        Route::post('/logos/store/{id?}',  [InicioController::class, 'storeLogos'])->name('logos.store');

        Route::get ('/logos/delete/{id}',  [InicioController::class, 'deleteLogos'])->name('logos.delete');

        Route::get ('/logos/restore/{id}', [InicioController::class, 'restoreLogos'])->name('logos.restore');

    });







    Route::group([

        'prefix' => 'empresa',

        'as'     => 'empresa.',

    ], function() {

        Route::post('/',             [EmpresaController::class, 'all']);

        Route::get ('/{id}',         [EmpresaController::class, 'find']);

        Route::post('/store/{id?}',  [EmpresaController::class, 'store']);

        Route::get ('/delete/{id}',  [EmpresaController::class, 'delete']);

        Route::get ('/restore/{id}', [EmpresaController::class, 'restore']);

        Route::post('/list-select',  [EmpresaController::class, 'listSelect']);

        Route::post('/slider',             [EmpresaController::class, 'allSlider']);

        Route::get ('/slider/{id}',         [EmpresaController::class, 'findSlider']);

        Route::post('/slider/store/{id?}',  [EmpresaController::class, 'storeSlider']);

        Route::get ('/slider/delete/{id}',  [EmpresaController::class, 'deleteSlider']);

        Route::get ('/slider/restore/{id}', [EmpresaController::class, 'restoreSlider']);

    });

    Route::group([

        'prefix' => 'calidad',

        'as'     => 'calidad.',

    ], function() {

        Route::post('/',             [CalidadController::class, 'all']);

        Route::get ('/{id}',         [CalidadController::class, 'find']);

        Route::post('/store/{id?}',  [CalidadController::class, 'store']);

        Route::get ('/delete/{id}',  [CalidadController::class, 'delete']);

        Route::get ('/restore/{id}', [CalidadController::class, 'restore']);

        Route::post('/list-select',  [CalidadController::class, 'listSelect']);        

    });

    Route::group([

        'prefix' => 'pedidos',

        'as'     => 'pedidos.',

    ], function() {

        Route::post('/',             [PedidoController::class, 'all']);

        Route::get ('/{id}',         [PedidoController::class, 'find']);

        Route::post('/store/{id?}',  [PedidoController::class, 'store']);

        Route::get ('/delete/{id}',  [PedidoController::class, 'delete']);

        Route::get ('/restore/{id}', [PedidoController::class, 'restore']);

        Route::post('/list-select',  [PedidoController::class, 'listSelect']);        

    });

    Route::group([

        'prefix' => 'comoComprar',

        'as'     => 'comoComprar.',

    ], function() {

        Route::post('/',             [ComoComprarController::class, 'all']);

        Route::get ('/{id}',         [ComoComprarController::class, 'find']);

        Route::post('/store/{id?}',  [ComoComprarController::class, 'store']);

        Route::get ('/delete/{id}',  [ComoComprarController::class, 'delete']);

        Route::get ('/restore/{id}', [ComoComprarController::class, 'restore']);

        Route::post('/list-select',  [ComoComprarController::class, 'listSelect']);        

    });



    Route::group([

        'prefix' => 'clientes',

        'as'     => 'clientes.',

    ], function() {

        Route::get ('/updateClientes',  [ClienteController::class, 'updateApi']);

        Route::post('/{page}',             [ClienteController::class, 'all']);

        Route::get ('/{id}',         [ClienteController::class, 'find']);

        Route::post('/store/{id?}',  [ClienteController::class, 'store']);

        Route::post('/storepass/{id}',  [ClienteController::class, 'storepass']);

        Route::get ('/delete/{id}',  [ClienteController::class, 'delete']);

        Route::get ('/restore/{id}', [ClienteController::class, 'restore']);

        Route::post('/list-select',  [ClienteController::class, 'listSelect']);

        Route::get('/habilitar/{id}',  [ClienteController::class, 'habilitar']);



    });    

    Route::group([

        'prefix' => 'clientespotenciales',

        'as'     => 'clientespotenciales.',

    ], function() {

        Route::post('/',             [ClientePotencialController::class, 'all']);

        Route::get ('/{id}',         [ClientePotencialController::class, 'find']);        

        Route::post('/store/{id?}',  [ClientePotencialController::class, 'store']);

        Route::get ('/delete/{id}',  [ClientePotencialController::class, 'delete']);        

    });   



    Route::group([

        'prefix' => 'formclientes',

        'as'     => 'formclientes.',

    ], function() {

        Route::post('/',             [FormularioClienteController::class, 'all']);

        Route::get ('/{id}',         [FormularioClienteController::class, 'find']);        

        Route::post('/store/{id?}',  [FormularioClienteController::class, 'store']);

        Route::get ('/delete/{id}',  [FormularioClienteController::class, 'delete']);        

    });   







    Route::group([

        'prefix' => 'clientestemp',

        'as'     => 'clientestemp.',

    ], function() {

        Route::post('/',             [ClienteController::class, 'allTemp']);

        Route::get ('/{id}',         [ClienteController::class, 'findTemp']);        

        Route::post('/store/{id?}',  [ClienteController::class, 'storeTemp']);

        Route::get ('/delete/{id}',  [ClienteController::class, 'delete']);        

    });  





    Route::group([

        'prefix' => 'redes',

        'as'     => 'redes.',

    ], function() {

        Route::post('/',             [RedesController::class, 'all']);

        Route::get ('/{id}',         [RedesController::class, 'find']);

        Route::post('/store/{id?}',  [RedesController::class, 'store']);

        Route::get ('/delete/{id}',  [RedesController::class, 'delete']);

        Route::get ('/restore/{id}', [RedesController::class, 'restore']);

        Route::post('/list-select',  [RedesController::class, 'listSelect']);

    });

    

    

    Route::group([

        'prefix' => 'listaPrecios',

        'as'     => 'listaPrecios.',

    ], function() {

        Route::post('/',             [DescargaController::class, 'all']);

        Route::get ('/{id}',         [DescargaController::class, 'find']);        

        Route::post('/store/{id?}',  [DescargaController::class, 'store']);

        Route::get ('/delete/{id}',  [DescargaController::class, 'delete']);        

    });    



    Route::group([

        'prefix' => 'articulo',

        'as'     => 'articulo.',

    ], function() {

        Route::post('',             [ArticuloController::class, 'all']);

        Route::get ('/{id}',         [ArticuloController::class, 'find']);

        Route::post('/store/{id}',  [ArticuloController::class, 'store']);

        Route::post('/storeColor/{id?}',  [ArticuloController::class, 'storeColor']);

        Route::get ('/delete/{id}',  [ArticuloController::class, 'delete']);

        Route::get ('/ocultar/{id}',  [ArticuloController::class, 'ocultar']);

        Route::get ('/updateArticulos/adios',  [ArticuloController::class, 'prueba']);

        Route::get ('/deleteImg/{id?}/{index?}',  [ArticuloController::class, 'deleteImg']);

        Route::get ('/deleteColor/{id}',  [ArticuloController::class, 'deleteColor']);

        Route::get ('/updateProducts',  [ArticuloController::class, 'updateProducts']);

        Route::get ('/restore/{id}', [ArticuloController::class, 'restore']);

        Route::post('/list-select',  [ArticuloController::class, 'listSelect']);

    });

    Route::group([

        'prefix' => 'informacionTecnica',

        'as'     => 'informacionTecnica.',

    ], function() {

        Route::post('/',             [InformacionTecnicaController::class, 'all']);

        Route::get ('/{id}',         [InformacionTecnicaController::class, 'find']);

        Route::post('/store/{id?}',  [InformacionTecnicaController::class, 'store']);

        Route::get ('/delete/{id}',  [InformacionTecnicaController::class, 'delete']);

        Route::get ('/restore/{id}', [InformacionTecnicaController::class, 'restore']);        

        Route::post('/list-select',  [InformacionTecnicaController::class, 'listSelect']);

    });



    Route::group([

        'prefix' => 'logosNuevos',

        'as'     => 'logosNuevos.',

    ], function() {

        Route::post('/',             [InicioController::class, 'allLogos']);

        Route::get ('/{id}',         [InicioController::class, 'findLogos']);

        Route::post('/store/{id?}',  [InicioController::class, 'storeLogos']);

        Route::get ('/delete/{id}',  [InicioController::class, 'deleteLogos']);

        Route::get ('/restore/{id}', [InicioController::class, 'restoreLogos']);

    });





    Route::group([

        'prefix' => 'sliders',

        'as'     => 'sliders.',

    ], function() {

        Route::post('/',             [InicioController::class, 'allSlider']);

        Route::get ('/{id}',         [InicioController::class, 'findSlider']);

        Route::post('/store/{id?}',  [InicioController::class, 'storeSlider']);

        Route::get ('/delete/{id}',  [InicioController::class, 'deleteSlider']);

        Route::get ('/restore/{id}', [InicioController::class, 'restoreSlider']);

    });



    

    Route::group([

        'prefix' => 'seccionesNaranjas',

        'as'     => 'seccionesNaranjas.',

    ], function() {

        Route::post('/',             [SeccionesController::class, 'all']);

        Route::get ('/{id}',         [SeccionesController::class, 'find']);

        Route::post('/store/{id?}',  [SeccionesController::class, 'store']);

        Route::get ('/delete/{id}',  [SeccionesController::class, 'delete']);

        Route::get ('/restore/{id}', [SeccionesController::class, 'restore']);        

        Route::post('/list-select',  [SeccionesController::class, 'listSelect']);

    });     

    

    

    Route::group([

        'prefix' => 'metricas',

        'as'     => 'metricas.',

    ], function() {

        Route::get('/datos',[MetricasController::class, 'datos']);

        Route::get('/clientes',[MetricasController::class, 'clientes']);

        Route::get('/productos',[MetricasController::class, 'productos']);

        Route::get('/pedidos',[MetricasController::class, 'datosPedidosCancelados']);

        Route::get('/referrer',[MetricasController::class, 'datosReferrer']);

    });   





    Route::group([

        'prefix' => 'tutoriales',

        'as'     => 'tutoriales.',

    ], function() {

        Route::post('/',             [TutorialesController::class, 'all']);

        Route::get ('/{id}',         [TutorialesController::class, 'find']);

        Route::post('/store/{id?}',  [TutorialesController::class, 'store']);

        Route::get ('/delete/{id}',  [TutorialesController::class, 'delete']);

        Route::get ('/restore/{id}', [TutorialesController::class, 'restore']);        

        Route::post('/list-select',  [TutorialesController::class, 'listSelect']);

    });        

    Route::group([

        'prefix' => 'tipo-articulo',

        'as'     => 'tipo-articulo.',

    ], function() {

        Route::post('/',             [TipoArticuloController::class, 'all']);
            Route::get ('/sincronizar',  [TipoArticuloController::class, 'sincronizarCategorias']); // AGREGAR


        Route::get ('/{id}',         [TipoArticuloController::class, 'find']);

        Route::post('/store/{id?}',  [TipoArticuloController::class, 'store']);

        Route::get ('/delete/{id}',  [TipoArticuloController::class, 'delete']);

        Route::get ('/ocultar/{id}',  [TipoArticuloController::class, 'ocultar']);

        Route::get ('/restore/{id}', [TipoArticuloController::class, 'restore']);

        Route::post('/list-select',  [TipoArticuloController::class, 'listSelect']);

        Route::get('/categorias',  [TipoArticuloController::class, 'categorias']);



    });



    Route::group([

        'prefix' => 'familia',

        'as'     => 'familia.',

    ], function() {

        Route::post('/',             [FamiliaController::class, 'all']);

        Route::get ('/{id}',         [FamiliaController::class, 'find']);

        Route::post('/store/{id?}',  [FamiliaController::class, 'store']);

        Route::get ('/delete/{id}',  [FamiliaController::class, 'delete']);

        Route::get ('/ocultar/{id}',  [FamiliaController::class, 'ocultar']);

        Route::get ('/restore/{id}', [FamiliaController::class, 'restore']);

        Route::post('/list-select',  [FamiliaController::class, 'listSelect']);

    });





    Route::group([

        'prefix' => 'sub-categoria',

        'as'     => 'sub-categoria.',

    ], function() {

        Route::post('/',             [SubCategoriaController::class, 'all']);

        Route::get ('/{id}',         [SubCategoriaController::class, 'find']);

        Route::post('/store/{id?}',  [SubCategoriaController::class, 'store']);

        Route::get ('/delete/{id}',  [SubCategoriaController::class, 'delete']);

        Route::get ('/restore/{id}', [SubCategoriaController::class, 'restore']);

        Route::post('/list-select',  [SubCategoriaController::class, 'listSelect']);

    });



    Route::group([

        'prefix' => 'vendedores',

        'as'     => 'vendedores.',

    ], function() {

        Route::post('/',             [VendedoresController::class, 'all']);

        Route::get ('/{id}',         [VendedoresController::class, 'find']);

        Route::post('/store/{id?}',  [VendedoresController::class, 'store']);

        Route::get ('/delete/{id}',  [VendedoresController::class, 'delete']);

        Route::get ('/restore/{id}', [VendedoresController::class, 'restore']);

        Route::post('/list-select',  [VendedoresController::class, 'listSelect']);

    });



    Route::group([

        'prefix' => 'contacto',

        'as'     => 'contacto.',

    ], function() {

        Route::post('/',             [ContactoController::class, 'all']);

        Route::get ('/{id}',         [ContactoController::class, 'find']);

        Route::post('/store/{id?}',  [ContactoController::class, 'store']);

        Route::get ('/delete/{id}',  [ContactoController::class, 'delete']);

        Route::get ('/restore/{id}', [ContactoController::class, 'restore']);

        Route::post('/list-select',  [ContactoController::class, 'listSelect']);

    });

    Route::group([

        'prefix' => 'carrito',

        'as'     => 'carrito.',

    ], function() {

        Route::post('/',             [ContactoController::class, 'carrito']);        

        Route::get ('/{id}',         [ContactoController::class, 'findCarrito']);

        Route::post('/store',  [ContactoController::class, 'storeCarrito']);        

    });

    Route::group([

        'prefix' => 'modal',

        'as'     => 'modal.',

    ], function() {

        Route::post('/',             [ContactoController::class, 'modal']);        

        Route::get ('/{id}',         [ContactoController::class, 'findModal']);

        Route::post('/store',        [ContactoController::class, 'storeModal']);        

    });    

    Route::group([

        'prefix' => 'metadatos',

        'as'     => 'metadatos.',

    ], function() {

        Route::post('/',             [MetadatosController::class, 'all']);

        Route::get ('/{id}',         [MetadatosController::class, 'find']);

        Route::post('/store/{id?}',  [MetadatosController::class, 'store']);

        Route::get ('/delete/{id}',  [MetadatosController::class, 'delete']);

        Route::get ('/restore/{id}', [MetadatosController::class, 'restore']);

        Route::post('/list-select',  [MetadatosController::class, 'listSelect']);

    });

    Route::group([

        'prefix' => 'logo',

        'as'     => 'logo.',

    ], function() {

        Route::post('/',             [LogoController::class, 'all']);

        Route::get ('/{id}',         [LogoController::class, 'find']);

        Route::post('/store/{id?}',  [LogoController::class, 'store']);

        Route::get ('/delete/{id}',  [LogoController::class, 'delete']);

        Route::get ('/restore/{id}', [LogoController::class, 'restore']);

        Route::post('/list-select',  [LogoController::class, 'listSelect']);

    });





    

 



    Route::group([

        'prefix' => 'stock',

        'as'     => 'stock.',

    ], function() {

        Route::post('/position/add',  [StockController::class, 'addPosition']);

        Route::get ('/articulo/{id}', [StockController::class, 'findArticulo']);

        Route::post('/articulo',      [StockController::class, 'allArticulo']);

    });



    Route::group([

        'prefix' => 'permission',

        'as'     => 'permission.',

    ], function() {

        Route::post('/',             [PermissionController::class, 'all']);

        Route::get ('/{id}',         [PermissionController::class, 'find']);

        Route::post('/store/{id?}',  [PermissionController::class, 'store']);

        Route::get ('/delete/{id}',  [PermissionController::class, 'delete']);

        Route::get ('/restore/{id}', [PermissionController::class, 'restore']);

    });

    

    Route::group([

        'prefix' => 'group',

        'as'     => 'group.',

    ], function() {

        Route::post('/',             [GroupController::class, 'all']);

        Route::get ('/{id}',         [GroupController::class, 'find']);

        Route::post('/store/{id?}',  [GroupController::class, 'store']);

        Route::get ('/delete/{id}',  [GroupController::class, 'delete']);

        Route::get ('/restore/{id}', [GroupController::class, 'restore']);

    });

    

    Route::group([

        'prefix' => 'user',

        'as'     => 'user.',

    ], function() {

        Route::post('/', function() {

            $data = User::orderBy('id', 'desc');

            if ( request()->has('filters') && is_array(request()->filters) ) {

                foreach (request()->filters as $key => $value) {

                    $data->where($key, 'like', '%'.$value.'%');

                }

            }

            return $data->paginate();

        });

        Route::post('store/{id?}', function (Request $request, $id = null) {

            // validate the request

            $request->validate([

                'name'     => 'required|string|max:255',

                'username' => 'required|string|max:255|unique:users' . ($id ? ",id,$id" : ''),

                'email'    => 'required|string|email|max:255|unique:users' . ($id ? ",id,$id" : ''),

                'password' => [

                    $id ? 'nullable' : 'required',

                    'string',

                    'min:6',

                ]

            ]);

            // store a new user

            if ($id) {

                $user = User::find($id);

            } else {

                $user = new User;

            }

            $user->name = $request->name;

            $user->username = $request->username;

            $user->email = $request->email;

            if ($request->password) {

                $user->password = bcrypt($request->password);

            }

            $user->save();

    

            return ['message' => 'Registro guardado'];

        });

        Route::get('{id}', function ($id) {

            $item = User::find($id);

            if ($item) {                

                return $item;

            }

            return response()->json(['message' => 'Item not found'], 404);    

        });

        Route::get('delete/{id}', function ($id) {

            $item = User::find($id);

            if ($item) {

                $item->delete();

                return response()->json(['message' => 'Registro eliminado']);

            }

            return response()->json(['message' => 'Item not found'], 404);    

        });

        Route::post('/list-select', function (Request $request) {

            $data = User::orderBy('id', 'desc');

            if ( request()->has('search') && strlen(request()->search) ) {

                $data->where(function($query) {

                    $keys = ['name'];

                    foreach ($keys as $key => $colName) {

                        $query->orWhere($colName, 'like', '%'.request()->search.'%');

                    }

                });

            }

            return $data->get();    

        });

    });

});



Route::get('check-auth', function () {

    try {

        $user = auth()->guard('web')->user();

        // get all permissions

        $allPermissions = Permission::get();

        $permissions = [];

        foreach ($allPermissions as $permission) {

            $permissions[$permission->name] = [

                'description' => $permission->description,

                'access' => false,

            ];

        }

        // Permission::create(['name' => 'add employees']);

        // $user->syncPermissions(['user-create']);

        // get all user permissions

        $userPermissions = $user->getAllPermissions();

        foreach ($userPermissions as $permission) {

            $permissions[$permission->name]['access'] = true;

        }

        return response()->json([

            'user' => [

                'id' => $user->id,

                'name' => $user->name,

                'email' => $user->email,

                'username' => $user->username,

                'permissions' => $permissions,

            ],

            'status' => 'success'

        ]);

    } catch (\Throwable $th) {

        return response()->json([

            'status' => 'error'

        ]);

    }

});



Route::post('login', function (Request $request) {

    // check if username is email or username

    if ( filter_var($request->username, FILTER_VALIDATE_EMAIL) ) {

        $credentials = [

            'email' => $request->username,

            'password' => $request->password,

        ];

    } else {

        $credentials = [

            'username' => $request->username,

            'password' => $request->password,

        ];

    }

    

    if ( ! auth()->guard('web')->attempt($credentials, true) ) {

        return response()->json(['error' => 'Unauthorized'], 401);

    }

    if($request->api == true){

        return response()->json(['vendedor' => 'authorized']);

    }

    return redirect()->intended('adm/check-auth');

    //return redirect()->intended('adm/check-auth');

});



Route::get('logout', function () {

    auth()->logout();

    return response()->json(['message' => 'Logged out']);

});