<style>
    .enlace,
    .link,
    .letraenlace {
        text-decoration: none;
    }

    .navbar-light .navbar-nav .nav-link {
        font-weight: 400;
        color: #000;
    }
    .activeheader {
        font-weight: 600;
        color: #000;
    }

    .ocultar_ {
        display: none;
    }

    .accordion-button {
        background-color: #fff;
        color: #000;
    }

    .accordion-button.collapsed {
        background-color: #fff;
        color: #000;
    }

    .accordion-button:not(.collapsed) {
        color: #000;
    }

    .accordion-button::after {
        background-image: unset;
        content: "►";
        transform: unset;
        font-size: 15px;
        color: #fff;
    }

    .accordion-button:not(.collapsed)::after {
        background-image: unset;
        content: "►";
        transform: unset;
        font-size: 15px;
        color: #ffff;
    }

    .accordion-item {
        border-left: none;
        border-right: none;
    }

    .page-link {
        color: #F15E40;
        border-color: #F15E40;
    }

    .page-item.active .page-link {
        background: #F15E40;
        color: #fff;
    }

    .navbar-light .navbar-nav .nav-link:focus,
    .navbar-light .navbar-nav .nav-link:hover {
        color: #F15E40;
    }

    /* .page-link{border: unset;color: #000}
    .page-item.active .page-link{background: unset;color: #000;border: 1px solid #000;border-radius: 30px;} */
    .novedadHover:hover {
        transform: scale(1.03);
        transition: all 0.5s ease 0.2s;
    }
</style>
<div class="container-fluid d-flex justify-content-center flex-wrap sticky-top p-0"
    style="background: #fff;box-shadow: 0px 3px 23px rgba(0, 0, 0, 0.1);">
    <nav class="navbar navbar-expand-lg navbar-light p-0 box_container">
        <div class="row justify-content-center align-items-center box_container flex-wrap" style="background: #fff;">
            <div class="d-flex flex-wrap flex-row justify-content-between align-items-center" style="border-bottom:1px solid #ddd;">
                <a class="navbar-brand my-3 p-0" href="{{ route('page.inicio') }}">
                    <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid ">
                </a>
                <div>
                    <button class="navbar-toggler mb-2 " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-center" id="navbarNavAltMarkup">
                <div class="navbar-nav  d-flex justify-content-between ml-auto mt-3 w-100">
                @if (isset(Auth::guard('cliente')->user()->id))
                <a class="nav-item nav-link mx-1 {{ $active == 'page.home' ? 'activeheader' : '' }}"
                href="{{ route('page.productosCategorias') }}">Catálogo</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.home' ? 'activeheader' : '' }}"
                href="{{ route('page.pedido') }}">Pedidos</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }}"
                href="{{ route('page.carrito') }}">Carrito</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }}"
                href="{{ route('page.historial') }}">Historial</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }}"
                href="{{ route('page.historial') }}">Lista de precios</a>
                @else
                <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }}"
                    href="{{ route('page.inicio') }}">Inicio</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }}"
                    href="{{ route('page.empresa') }}">Quienes somos</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }}"
                    href="{{ route('page.productosCategorias') }}">Productos</a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.novedades' ? 'activeheader' : '' }}"
                    href="{{ route('page.tutoriales') }}">Tutoriales</a>                    
                <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }}"
                    href="{{ route('page.contacto') }}">Contacto</a>
                @endif
                </div>
            </div>
                </div>
                
                @if (isset(Auth::guard('cliente')->user()->id))
                    <div class="dropdown">
                        <button style="background:#F15E40;border-radius:35px;" class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('cliente')->user()->username }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                            style="width: 237px;min-width: unset;">
                            <li><a class="nav-item nav-link px-2 dropdown-item" href="{{route('page.mi.perfil')}}"
                                    style="cursor:pointer;text-align: center;">Mi perfil</a></li>

                            <li><a class="nav-item nav-link px-2 dropdown-item" href="{{ asset(Storage::url('/listas/LISTA DE PRECIOS GENERAL.xlsx')) }}"
                                    style="cursor:pointer;text-align: center;">Lista de Precios General Excel</a></li>
                            <li><a class="nav-item nav-link px-2 dropdown-item" href="{{ asset(Storage::url('/listas/LISTA DE PRECIOS GENERAL.pdf')) }}"
                                    style="cursor:pointer;text-align: center;">Lista de Precios General PDF</a></li>
                            <li><a class="nav-item nav-link px-2 dropdown-item" href="{{ asset(Storage::url('/listas/LISTA DE PRECIOS.xlsx')) }}"
                                    style="cursor:pointer;text-align: center;">Lista de Precios</a></li>
                            <li><a class="nav-item nav-link px-2 dropdown-item" onclick="salir_clientes()"
                                    style="cursor:pointer;text-align: center;">Salir</a></li>
                        </ul>
                    </div>                    
                @else
                    <button class="btn zp_container py-1 px-4" type="button"
                        style="color:#fff;background:#F15E40;border-radius:35px;">
                         Iniciar sesion
                    </button>                    
                        <div id="area_privada" class="ocultar_"
                            style="position:absolute;width:295px;height:315px;top:112px;right:13;z-index:101;background:#f2f2f2;border-radius:15px;right: 0;">
                            <div class="container">
                                <div class="justify-content-center align-items-center">
                                    <div class="col-md-12">
                                        <div class="card-body px-0 pt-3">
                                            @isset($msj)
                                                <div>{{ $msj }}</div>
                                            @endisset

                                            <form method="POST" action="{{ route('login.clientes') }}" autocomplete="off">
                                                @csrf
                                                <span style="color:#F15E40;font-size:20px;"><b>INGRESO PARA
                                                        CLIENTES</b></span>
                                                <div
                                                    class="mt-3 form-group row d-flex justify-content-center align-items-center">
                                                    <div class="col-md-10 p-0">
                                                        <span style="color:#000;font-size:16px;"><b>Usuario</b></span>
                                                        <input
                                                            style="background:transparent;color:#000;border-color:#F15E40;"
                                                            id="username" type="text"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            name="username" value="{{ old('username') }}" required
                                                            autocomplete="username" autofocus>
                                                    </div>
                                                </div>

                                                <div
                                                    class="mt-3 form-group row d-flex justify-content-center align-items-center">
                                                    <div class="col-md-10 p-0">
                                                        <span
                                                            style="color:#000;font-size:16px;"><b>Contraseña</b></span>
                                                        <input
                                                            style="background:transparent;color:#000;border-color:#F15E40;"
                                                            id="password" type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" required autocomplete="current-password">
                                                    </div>
                                                </div>

                                                <div
                                                    class="mt-3 form-group row mb-0 d-flex justify-content-center align-items-center">
                                                    <div
                                                        class="col-md-10 d-flex justify-content-center align-items-center px-0">
                                                        <button
                                                            style="background:#F15E40;color: #fff;border-radius:35px;"
                                                            type="submit" class="btn w-100">
                                                            INGRESAR
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="w-100 text-center d-none">
                                                <a href="{{ route('page.registro') }}">Registrarme</a><br>
                                                {{-- <a href="{{ route('password') }}">Olvide mi contraseña</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
            
            <div class="d-flex ms-3" style="width: auto">
                <div class="d-flex flex-row align-items-start">
                    @forelse($redes as $r)
                        <div style="height:20px;" class="d-flex align-items-center">
                            <a href="{{ $r->link }}" target="_blank" style="color:transparent;">
                                @if ($r->name == 'FACEBOOK')
                                    <i class="px-3 icono fab fa-facebook-f text-white"></i>
                                @elseif ($r->name == 'INSTAGRAM')
                                    <i class="px-3 icono fab fa-instagram text-white"></i>
                                @elseif ($r->name == 'YOUTUBE')
                                    <i class="px-3 icono fab fa-youtube text-white"></i>
                                @elseif ($r->name == 'TWITTER')
                                    <i class="px-3 icono fab fa-twitter text-white"></i>
                                @endif
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex flex-column justify-content-center align-items-center">
    @if (!request()->routeIs('page.productosPedido') && !request()->routeIs('page.productosPedidoSearch') && !request()->routeIs('page.productosCategorias'))
        <form method="POST" style="position: relative"  class="box_container d-flex justify-content-center align-items-center pb-4" action="{{route('page.productosSearch')}}">
            @csrf
            <input type="text" list="articulos" class="form-control mx-2" name="search" placeholder="Ingresa tu busqueda.." oninput="toggleDatalist()" style="max-width: 250px;">
            <datalist id="articulos" style="display: none;">
                @forelse ($articulosList as $art)
                    <option value="{{$art->name}}">{{$art->name}}</option>
                    <option value="{{$art->code}}">{{$art->code}}</option>
                @empty
                    
                @endforelse
            </datalist>
            <button class="btn" style="background: #F15E40;border-radius:45px;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    @endif
    @if (isset(Auth::guard('cliente')->user()->id))
        @if (request()->routeIs('page.productosCategorias'))
            <div class="box_container pt-5 d-flex justify-content-between align-items-center">
                    <span style="cursor: pointer" onclick="window.location='{{ route('page.pedido') }}'"></span>            
                        <form method="POST" style="position: relative" class="d-flex justify-content-end align-items-center mb-4" action="{{route('page.productosPedidoSearch',0)}}">
                            @csrf
                            <input class="form-control w-100" list="articulosC" name="search" style="height: 40px;border-radius: 10px;">
                            <datalist id="articulosC">
                                @forelse ($articulosList as $art)
                                    <option value="{{$art->name}}">{{$art->name}}</option>
                                    <option value="{{$art->code}}">{{$art->code}}</option>
                                    @if($art->codigoAnterior)
                                    <option value="{{$art->code}}">{{$art->codigoAnterior}}</option>
                                    @endif
                                @empty
                                    
                                @endforelse
                            </datalist>
                            <button
                                class="h-100 d-flex justify-content-center align-items-center"
                                style="cursor: pointer;border-radius: 0px 10px 10px 0px;background: #ddd;position: absolute"
                                class="px-2">
                                <img class="mx-3" src="{{ asset('images/search.svg') }}" width="24px" height="24px">
                            </button>
                        </form>            
                    
                        <span></span>
                    
                </div>
            </div>
        @endif
    @endif
    @if ($errors->has('msj'))
        <div class="row justify-content-center align-items-center box_container flex-wrap" style="background: #fff;">
            <div class="alert alert-danger">
                {{ $errors->first('msj') }}
            </div>
        </div>
        @endif
</div>
<script>
    // Obtener el elemento con la clase 'alert'
    var alertElement = document.querySelector('.alert');

    // Si existe el elemento de alerta
    if (alertElement) {
        // Ocultar el elemento de alerta después de 5 segundos
        setTimeout(function() {
            alertElement.style.display = 'none';
        }, 5000); // 5000 milisegundos = 5 segundos
    }
</script>
<script> 
    function toggleDatalist()
    {
        var input = document.querySelector('input[name="search"]');
        var datalist = document.getElementById('articulos');
        if (input.value.trim() === '') { 
            console.log('esta vacio');
            datalist.style.display = 'none';
        } else { 
            datalist.style.display = '';
        }
    }
</script>