<style>
    #idioma {
        background: transparent;
        color: white;
        border: none;
    }

    #idioma option {
        color: #000;
        /* Color del texto de las opciones */
        background-color: #fff;
        /* Color de fondo de las opciones */
    }

    .ui-menu {

        z-index: 1500 !important;
        position: relative !important;
    }


    .enlace,
    .link,
    .letraenlace {
        text-decoration: none;
    }

    .navbar-light .navbar-nav .nav-link {
        font-weight: 400;
        color: #fff;
    }

    .activeheader {
        font-weight: 600;
        color: #fff;
        box-shadow: inset 0 -6px 0 0 #F14B40;
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
        color: #fff;
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

    .novedadHover:hover {
        transform: scale(1.03);
        transition: all 0.5s ease 0.2s;
    }

    .newnav-link {
        color: #fff;
        font-weight: 600;
        height: 100%;
        align-content: center;
    }

    .newnav-link:hover {
        color: #F15E40 !important;
    }

    #search::placeholder {
        color: #FFFFFF;
    }

    .fa-search {
        position: absolute;
        right: 10px;
        top: 10px;
        color: #fff;
    }

    .search-container {
        position: relative;

    }

    .navbar-toggler-icon {
        filter: invert(100%);
    }

    .navNew {
        display: none
    }

    .navMobile {
        display: none
    }

    @media (max-width: 308px) {

        .navbar-brand {
            margin-right: 0px !important;
        }

        .navOld {
            display: none !important
        }

        .navNew {
            display: none !important
        }

        .navMobile {
            display: flex;

        }

    }

    @media (max-width: 800px) {
        .mobileContant {
            display: flex !important;
        }

        .pcContant {
            display: none !important;
        }


    }

    @media (max-width: 400px) {




        .navbar-brand {
            margin-right: 0px !important;
        }

        .img-fluid {
            max-width: 70% !important;
        }

        .botonesIg div {
            display: flex !important;
        }

        .botonesIg div {
            gap: 0px !important
        }
    }

    @media (max-width: 1000px) {
        .ui-menu {
            width: 50% !important;
        }

        .contMobile {
            margin-top: 10px;
            margin-bottom: 30px;

        }

        .contMobile div {
            padding-top: 5px !important
        }

        .nav-link {
            font-size: 16px !important;
            padding: 1rem 1rem !important;
        }

        #navbarNavAltMarkup div button {
            margin-bottom: 20px !important;
        }

        .fotterM {
            width: 100% !important;
            height: auto !important;
        }

        .iconosF {
            width: 30px !important
        }


        .botonesIg {
            margin-top: 50px !important
        }

        .footerDiv {
            height: auto !important;
        }


        .navOld {
            display: none !important
        }

        .navNew {
            display: flex;

        }

        .box_container {
            width: 100% !important;
        }



        .inicoSlider {
            height: 640px !important;
            padding-bottom: 50px !important;
            width: 100% !important;
        }
    }
</style>
<div class="container-fluid d-flex justify-content-center flex-wrap sticky-top p-0"
    style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($empresa->fondoNavbar)) }});background-size:cover">
    <nav class="navbar navbar-expand-lg navbar-light p-0 box_container justify-content-between navOld"
        style="z-index: 2; border-bottom: 1px solid white;">
        <div class="d-flex flex-wrap flex-row justify-content-between align-items-center">
            <a class="navbar-brand my-3 p-0" href="{{ route('page.productosCategorias') }}">
                <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid ">
            </a>
        </div>
        <div class="d-flex align-items-center d-none d-lg-flex" style="height:100%">
            @if (!Auth::guard('cliente')->check())

                <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.inicio') }}">
                    @if (session('locale') === 'es')
                        Inicio
                    @else
                        Start
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.empresa') }}">
                    @if (session('locale') === 'es')
                        Quienes somos
                    @else
                        Who we are
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Productos
                    @else
                        Products
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.contacto') }}">
                    @if (session('locale') === 'es')
                        Contacto
                    @else
                        Contact
                    @endif
                </a>
            @else
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Catálogo
                    @else
                        Catalog
                    @endif
                </a>
             
                <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.carrito') }}">
                    @if (session('locale') === 'es')
                        Carrito
                    @else
                        Cart
                    @endif
                    <span id="cantidad-carrito">(0)</span>
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.historial') }}">
                    @if (session('locale') === 'es')
                        Historial
                    @else
                        Records
                    @endif
                </a>

                <a class="nav-item nav-link mx-1 {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.mi.perfil') }}">
                @if (session('locale') === 'es')
                    Mi perfil
                @else
                My profile
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.listaPrecios' ? 'activeheader' : '' }} newnav-link"
            href="{{ route('page.listadeprecios') }}">
            @if (session('locale') === 'es')
                Lista de precios
            @else
            Price list
            @endif
        </a>
            @endif
        </div>
        <div class="d-flex align-items-center d-lg-none">
            <button class="navbar-toggler mb-2 " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column align-items-center" id="navbarNavAltMarkup">
                <div class="navbar-nav  d-flex justify-content-between ml-auto mt-3 w-100">
                    @if (!Auth::guard('cliente')->check())

                        <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }}"
                            href="{{ route('page.inicio') }}">
                            @if (session('locale') === 'es')
                                Inicio
                            @else
                                Start
                            @endif
                        </a>
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }}"
                            href="{{ route('page.empresa') }}">
                            @if (session('locale') === 'es')
                                Quienes somos
                            @else
                                Who we are
                            @endif
                        </a>
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }}"
                            href="{{ route('page.productosCategorias') }}">
                            @if (session('locale') === 'es')
                                Productos
                            @else
                                Products
                            @endif
                        </a>
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }}"
                            href="{{ route('page.contacto') }}">
                            @if (session('locale') === 'es')
                                Contacto
                            @else
                                Contact
                            @endif
                        </a>
                        <button class="btn zp_container py-1 px-4" type="button"
                            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                            @if (session('locale') === 'es')
                                Iniciar sesion
                            @else
                                Login
                            @endif
                        </button>
                    @else
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }} newnav-link"
                            href="{{ route('page.productosCategorias') }}">
                            @if (session('locale') === 'es')
                                Catálogo
                            @else
                                Catalog
                            @endif
                        </a>
                    
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }} newnav-link"
                            href="{{ route('page.carrito') }}">
                            @if (session('locale') === 'es')
                                Carrito
                            @else
                                Cart
                            @endif
                            <span id="cantidad-carrito">(0)</span>

                        </a>
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }} newnav-link"
                            href="{{ route('page.historial') }}">
                            @if (session('locale') === 'es')
                                Historial
                            @else
                                Records
                            @endif
                        </a>
                        <a class="nav-item nav-link mx-1 {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }} newnav-link"
                        href="{{ route('page.mi.perfil') }}">
                        @if (session('locale') === 'es')
                            Mi perfil
                        @else
                        My profile
                        @endif
                    </a>
                        <button onclick="salir_clientes()" class="btn  py-1 px-4 d-none d-lg-block" type="button"
                            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                            @if (session('locale') === 'es')
                            Cerrar sesion
        
                        @else
                        log out
                        @endif                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex">
            <form method="POST" action="{{ route('page.productosSearch') }}" id="search-form">
                @csrf
                <div class="search-container">
                    <input type="text" id="search-form-desktop" name="search" class="py-1 px-4"
                        style="width:144px;border-radius:35px; border: solid 2px #fff; background: none; color: #fff;"
                        @if (session('locale') === 'es') placeholder="Buscar"    
                @else
                 placeholder="Search" @endif>
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </form>

            @if (!Auth::guard('cliente')->check())
                <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
                    style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                    @if (session('locale') === 'es')
                        Iniciar sesion
                    @else
                        Login
                    @endif
                </button>
            @else
                <button onclick="salir_clientes()" class="btn  py-1 px-4 d-none d-lg-block" type="button"
                    style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">

                    @if (session('locale') === 'es')
                    Cerrar sesion

                @else
                log out
                @endif
                </button>

            @endif
        </div>
        <div>
            <form action="{{ route('changeIdioma') }}" method="POST">
                @csrf
                <select name="idioma" id="idioma" onchange="this.form.submit()">
                    <option value="es" {{ session('locale') === 'es' ? 'selected' : '' }}>Español (ES)</option>
                    <option value="en" {{ session('locale') === 'en' ? 'selected' : '' }}>English (EN)</option>
                </select>
            </form>

        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light p-0 box_container justify-content-around navNew"
        style="z-index: 2; border-bottom: 1px solid white;">
        <div class="d-flex flex-wrap flex-row justify-content-between align-items-center">
            <a class="navbar-brand my-3 p-0" href="{{ route('page.productosCategorias') }}">
                <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid ">
            </a>
        </div>
        <div class="d-flex align-items-center d-none d-lg-flex" style="height:100%">
            @if (!Auth::guard('cliente')->check())

            <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.inicio') }}">
                @if (session('locale') === 'es')
                    Inicio
                @else
                    Start
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.empresa') }}">
                @if (session('locale') === 'es')
                    Quienes somos
                @else
                    Who we are
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.productosCategorias') }}">
                @if (session('locale') === 'es')
                    Productos
                @else
                    Products
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.contacto') }}">
                @if (session('locale') === 'es')
                    Contacto
                @else
                    Contact
                @endif
            </a>
            @else
            <a class="nav-item nav-link mx-1 {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }} newnav-link"
            href="{{ route('page.productosCategorias') }}">
            @if (session('locale') === 'es')
                Catálogo
            @else
                Catalog
            @endif
        </a>
    
        <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }} newnav-link"
            href="{{ route('page.carrito') }}">
            @if (session('locale') === 'es')
                Carrito
            @else
                Cart
            @endif
            <span id="cantidad-carrito">(0)</span>

        </a>
        <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }} newnav-link"
            href="{{ route('page.historial') }}">
            @if (session('locale') === 'es')
                Historial
            @else
                Records
            @endif
        </a>
        <a class="nav-item nav-link mx-1 {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }} newnav-link"
        href="{{ route('page.mi.perfil') }}">
        @if (session('locale') === 'es')
            Mi perfil
        @else
        My profile
        @endif
    </a>
            @endif


        </div>

        <div class="d-flex">
            <form method="POST" action="{{ route('page.productosSearch') }}" id="search-form">
                @csrf
                <div class="search-container">
                    <input type="text" id="search-form-tablet" name="search" class="py-1 px-4"
                        style="width:144px;border-radius:35px; border: solid 2px #fff; background: none; color: #fff;"
                        @if (session('locale') === 'es') placeholder="Buscar"    
                @else
                 placeholder="Search" @endif>
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </form>
            @if (!Auth::guard('cliente')->check())

            <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                @if (session('locale') === 'es')
                    Iniciar sesion
                @else
                    Login
                @endif
            </button>
            @else
            <button onclick="salir_clientes()" class="btn  py-1 px-4 d-none d-lg-block" type="button"
            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
            @if (session('locale') === 'es')
            Cerrar sesion

        @else
        log out
        @endif        </button>
            @endif

        </div>

        <div class="d-flex align-items-center d-lg-none">
            <button class="navbar-toggler mb-2 " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse flex-column align-items-center mt-4" id="navbarNavAltMarkup">
            <div class="navbar-nav d-flex justify-content-between">
                @if (!Auth::guard('cliente')->check())

                <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }}"
                    href="{{ route('page.inicio') }}">
                    @if (session('locale') === 'es')
                        Inicio
                    @else
                        Start
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }}"
                    href="{{ route('page.empresa') }}">
                    @if (session('locale') === 'es')
                        Quienes somos
                    @else
                        Who we are
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }}"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Productos
                    @else
                        Products
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }}"
                    href="{{ route('page.contacto') }}">
                    @if (session('locale') === 'es')
                        Contacto
                    @else
                        Contact
                    @endif
                </a>
                <button class="btn zp_container py-1 px-4" type="button"
                    style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                    @if (session('locale') === 'es')
                        Iniciar sesion
                    @else
                        Login
                    @endif
                </button>
                @else
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.productosCategorias') }}">
                @if (session('locale') === 'es')
                    Catálogo
                @else
                    Catalog
                @endif
            </a>
         
            <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.carrito') }}">
                @if (session('locale') === 'es')
                    Carrito
                @else
                    Cart
                @endif
                <span id="cantidad-carrito">(0)</span>

            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.historial') }}">
                @if (session('locale') === 'es')
                    Historial
                @else
                    Records
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }} newnav-link"
            href="{{ route('page.mi.perfil') }}">
            @if (session('locale') === 'es')
                Mi perfil
            @else
            My profile
            @endif
        </a>

            <button onclick="salir_clientes()" class="btn py-1 px-4 d-lg-block" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                @if (session('locale') === 'es')
                Cerrar sesion

            @else
            log out
            @endif            </button>
                @endif


            </div>
        </div>
        <div>
            <form action="{{ route('changeIdioma') }}" method="POST">
                @csrf
                <select name="idioma" id="idioma" onchange="this.form.submit()">
                    <option value="es" {{ session('locale') === 'es' ? 'selected' : '' }}>Español (ES)</option>
                    <option value="en" {{ session('locale') === 'en' ? 'selected' : '' }}>English (EN)</option>
                </select>
            </form>

        </div>
    </nav>

    <nav class="navbar navbar-expand-lg navbar-light p-0 box_container justify-content-around navMobile"
        style="z-index: 2; border-bottom: 1px solid white;">
        <div class="d-flex flex-wrap flex-row justify-content-between align-items-center">
            <a class="navbar-brand my-3 p-0" href="{{ route('page.productosCategorias') }}">
                <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid ">
            </a>
        </div>
        <div class="d-flex align-items-center d-none d-lg-flex" style="height:100%">
            @if (!Auth::guard('cliente')->check())

            <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.inicio') }}">
                @if (session('locale') === 'es')
                    Inicio
                @else
                    Start
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.empresa') }}">
                @if (session('locale') === 'es')
                    Quienes somos
                @else
                    Who we are
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.productosCategorias') }}">
                @if (session('locale') === 'es')
                    Productos
                @else
                    Products
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.contacto') }}">
                @if (session('locale') === 'es')
                    Contacto
                @else
                    Contact
                @endif
            </a>
            @else
            <a class="nav-item nav-link mx-1 {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Catálogo
                    @else
                        Catalog
                    @endif
                </a>
         
                <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.carrito') }}">
                    @if (session('locale') === 'es')
                        Carrito
                    @else
                        Cart
                    @endif
                    <span id="cantidad-carrito">(0)</span>

                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }} newnav-link"
                    href="{{ route('page.historial') }}">
                    @if (session('locale') === 'es')
                        Historial
                    @else
                        Records
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.mi.perfil') }}">
                @if (session('locale') === 'es')
                    Mi perfil
                @else
                My profile
                @endif
            </a>
            @endif
        </div>

        <div class="d-flex align-items-center d-lg-none">
            <button class="navbar-toggler mb-2 " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="d-flex">
            <form method="POST" action="{{ route('page.productosSearch') }}" id="search-form">
                @csrf
                <div class="search-container">
                    <input type="text" id="search-form-mobile" name="search" class="py-1 px-4"
                        style="width:144px;border-radius:35px; border: solid 2px #fff; background: none; color: #fff;"
                        @if (session('locale') === 'es') placeholder="Buscar"    
                @else
                 placeholder="Search" @endif>
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </form>
            @if (!Auth::guard('cliente')->check())

            <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                @if (session('locale') === 'es')
                    Iniciar sesion
                @else
                    Login
                @endif
            </button>
            @else
            <button onclick="salir_clientes()" class="btn  py-1 px-4 d-none d-lg-block" type="button"
            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
            @if (session('locale') === 'es')
            Cerrar sesion

        @else
        log out
        @endif        </button>
            @endif

        </div>



        <div class="collapse navbar-collapse flex-column align-items-center mt-4" id="navbarNavAltMarkup">
            <div class="navbar-nav d-flex justify-content-between">
                @if (!Auth::guard('cliente')->check())

                <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }}"
                    href="{{ route('page.inicio') }}">
                    @if (session('locale') === 'es')
                        Inicio
                    @else
                        Start
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.empresa' ? 'activeheader' : '' }}"
                    href="{{ route('page.empresa') }}">
                    @if (session('locale') === 'es')
                        Quienes somos
                    @else
                        Who we are
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productos' ? 'activeheader' : '' }}"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Productos
                    @else
                        Products
                    @endif
                </a>
                <a class="nav-item nav-link mx-1 {{ $active == 'page.contacto' ? 'activeheader' : '' }}"
                    href="{{ route('page.contacto') }}">
                    @if (session('locale') === 'es')
                        Contacto
                    @else
                        Contact
                    @endif
                </a>
                @else
                <a class="nav-item nav-link mx-1 {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.productosCategorias') }}">
                @if (session('locale') === 'es')
                    Catálogo
                @else
                    Catalog
                @endif
            </a>
         
            <a class="nav-item nav-link mx-1 {{ $active == 'page.carrito' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.carrito') }}">
                @if (session('locale') === 'es')
                    Carrito
                @else
                    Cart
                @endif
                <span id="cantidad-carrito">(0)</span>

            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.historial' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.historial') }}">
                @if (session('locale') === 'es')
                    Historial
                @else
                    Records
                @endif
            </a>
            <a class="nav-item nav-link mx-1 {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }} newnav-link"
            href="{{ route('page.mi.perfil') }}">
            @if (session('locale') === 'es')
                Mi perfil
            @else
            My profile
            @endif
        </a>
                @endif

                <div>
                    <form action="{{ route('changeIdioma') }}" method="POST">
                        @csrf
                        <select name="idioma" id="idioma" onchange="this.form.submit()">
                            <option value="es" {{ session('locale') === 'es' ? 'selected' : '' }}>Español (ES)
                            </option>
                            <option value="en" {{ session('locale') === 'en' ? 'selected' : '' }}>English (EN)
                            </option>
                        </select>
                    </form>

                </div>

                @if (!Auth::guard('cliente')->check())

                <button class="btn zp_container py-1 px-4" type="button"
                    style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                    @if (session('locale') === 'es')
                        Iniciar sesion
                    @else
                        Login
                    @endif
                </button>
                @else
                <button onclick="salir_clientes()" class="btn  py-1 px-4  d-lg-block" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                @if (session('locale') === 'es')
                Cerrar sesion

            @else
            log out
            @endif            </button>

        @endif
            </div>
        </div>

    </nav>
</div>
<script>
    function searchHandler(formId) {
        $(formId).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/buscar-productos', // Ruta para la solicitud AJAX
                    dataType: 'json',
                    data: {
                        term: request.term // Enviar el término de búsqueda
                    },
                    success: function(data) {
                        console.log(data, 'whts??')
                        response($.map(data, function(item) {
                            return {
                                label: item.name + ' (' + item.code +
                                ')', // Lo que se muestra en el dropdown
                                value: item
                                .name, // Valor seleccionado al hacer clic
                                code: item.code,
                                codigoAnterior: item
                                .codigoAnterior, // Código del producto
                                description: item
                                    .description // Descripción del producto
                            };
                        }));
                    }
                });
            },
            minLength: 2, // Mínimo de caracteres para iniciar la búsqueda
   select: function(event, ui) {
    console.log("Enviando al backend:", ui.item);
    $(this).val(ui.item.code); // o ui.item.value según el caso
    $(this).closest("form").submit();
}
        });
    }

        
    function contarProductosEnCarrito() {
    const obj_fila = localStorage.getItem('obj_fila');
    let cantidadTotal = 0;

    if (obj_fila) {
        try {
            const productos = JSON.parse(obj_fila); // Intenta convertir a objeto
            
            // Verifica si es un array y tiene elementos
            if (Array.isArray(productos) && productos.length > 0) {
                cantidadTotal = productos.length; // Contamos la cantidad de productos
            }
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            cantidadTotal = 0; // En caso de error, retornamos 0
        }
    }

    console.log(cantidadTotal, 'Cantidad total de productos en el carrito'); // Para depurar
    $('#cantidad-carrito').text('(' + cantidadTotal + ')'); // Muestra la cantidad en el DOM
}

// Llama a la función para verificar
contarProductosEnCarrito();





    searchHandler('#search-form-desktop');
    searchHandler('#search-form-mobile');
    searchHandler('#search-form-tablet');


    function toggleDatalist() {
        const input = this.value.toLowerCase();
        const datalist = document.getElementById('articulos');
        const options = datalist.querySelectorAll('option');

        options.forEach(option => {
            const name = option.value.toLowerCase();
            const code = option.getAttribute('data-code').toLowerCase();
            const description = option.getAttribute('data-description').toLowerCase();

            if (name.includes(input) || code.includes(input) || description.includes(input)) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    }
</script>
