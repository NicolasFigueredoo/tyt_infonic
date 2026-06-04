<style>
    .language-dropdown {
        position: relative;
    }

    .language-toggle {
        background: transparent;
        color: #fff;
        border: none;
        outline: none;
        font-weight: 600;
        font-size: 15px;
        padding: 6px 24px 6px 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        line-height: 1.2;
        white-space: nowrap;
    }

    .language-toggle::after {
        content: "";
        width: 11px;
        height: 7px;
        display: inline-block;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1.5L6 6.5L11 1.5' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
    }

    .language-menu {
        min-width: 150px;
        padding: 6px;
        margin-top: 8px;
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 12px;
        background: rgba(22, 20, 20, 0.96);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.35);
        overflow: hidden;
    }

    .language-menu form {
        margin: 0;
        padding: 0;
    }

    .language-menu button {
        width: 100%;
        border: none;
        background: transparent;
        color: #fff;
        text-align: left;
        padding: 9px 12px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.2;
        cursor: pointer;
    }

    .language-menu button:hover,
    .language-menu button.active {
        background: #F15E40;
        color: #fff;
        font-weight: 700;
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

    .accordion-button::after,
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
        height: 100% !important;
        align-content: center;
        position: relative;
        white-space: nowrap;
    }

    .newnav-link:hover {
        color: #F15E40 !important;
    }

    .activeheader {
        font-weight: 600;
        color: #fff !important;
        box-shadow: none !important;
        position: relative;
    }

    .activeheader::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 5px;
        background-color: #F14B40;
    }

    #search::placeholder,
    #search-form-input::placeholder {
        color: #FFFFFF;
    }

    .search-container {
        position: relative;
    }

    .fa-search {
        position: absolute;
        right: 10px;
        top: 10px;
        color: #fff;
    }

    .navbar-toggler-icon {
        filter: invert(100%);
    }

    .navbar-toggler {
        border: none !important;
        box-shadow: none !important;
        padding-right: 0 !important;
    }

    .navbar-toggler:focus {
        box-shadow: none !important;
    }

    .bg-pc,
    .bg-mobile {
        background: transparent !important;
    }

    .mobileContant {
        display: none !important;
    }

    .newInicioPage,
    .contenedorIm,
    .headerComun {
        width: 100% !important;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .nav-unico {
        width: 100%;
        max-width: 1223px;
        min-height: 88px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0;
        border-bottom: 1px solid white;
        z-index: 2;
        position: relative;
        flex-wrap: nowrap;
        margin-left: auto;
        margin-right: auto;
        background: transparent !important;
    }

    .nav-unico .navbar-brand {
        margin-right: 0;
        flex-shrink: 0;
    }

    .nav-unico .navbar-brand img {
        max-height: 76px;
        width: auto;
    }

    .nav-unico .desktop-links {
        height: 100%;
    }

    .nav-unico .nav-link {
        font-size: 15px;
    }

    .nav-unico .btn {
        white-space: nowrap;
    }

    #navCollapseUnico {
        position: static !important;
        top: auto !important;
        right: auto !important;
        left: auto !important;
        width: 100% !important;
        flex-basis: 100% !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        background: transparent !important;
        margin-top: 0 !important;
        z-index: 3;
    }

    #navCollapseUnico .navbar-nav {
        gap: 0;
        background: transparent !important;
    }

    #navCollapseUnico .nav-link {
        color: #fff;
        line-height: 1.25;
    }

    #navCollapseUnico .btn {
        line-height: 1.25;
    }

    @media (min-width: 992px) {
        #navCollapseUnico {
            display: none !important;
        }
    }

    @media (min-width: 1200px) {
        .nav-unico {
            max-width: 1223px;
        }

        .nav-unico .navbar-brand img {
            max-height: 76px;
        }

        .nav-unico .nav-link {
            font-size: 15px;
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        .nav-unico {
            max-width: calc(100% - 40px);
            padding: 0;
        }

        .nav-unico .navbar-brand img {
            max-height: 68px;
        }

        .nav-unico .nav-link {
            font-size: 13px;
            padding-left: 0.45rem !important;
            padding-right: 0.45rem !important;
        }

        .nav-unico .btn {
            font-size: 13px;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .nav-unico .search-container input {
            width: 120px !important;
        }

        .language-toggle {
            font-size: 13px;
        }

        .language-menu {
            min-width: 135px;
        }

        .language-menu button {
            font-size: 13px;
        }
    }

    @media (max-width: 991.98px) {
        .ui-menu {
            width: 50% !important;
        }

        .newInicioPage,
        .contenedorIm,
        .headerComun {
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .nav-unico {
            width: calc(100% - 40px) !important;
            max-width: calc(100% - 40px) !important;
            min-height: 78px;
            padding: 0;
            flex-wrap: wrap !important;
            align-items: center;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .nav-unico .navbar-brand img {
            max-height: 68px;
        }

        .nav-unico .search-container input {
            width: 130px !important;
        }

        .nav-unico > .d-flex.align-items-center {
            margin-left: auto;
        }

        #navCollapseUnico {
            position: static !important;
            top: auto !important;
            right: auto !important;
            left: auto !important;
            width: 100% !important;
            flex-basis: 100% !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background: transparent !important;
            margin-top: 0 !important;
            z-index: 3;
        }

        #navCollapseUnico .navbar-nav {
            width: 100%;
            padding: 12px 0 18px 0 !important;
            background: transparent !important;
        }

        #navCollapseUnico .nav-link {
            width: 100%;
            display: block;
            color: #fff !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            padding: 8px 0 !important;
            line-height: 1.25 !important;
            margin: 0 !important;
            text-align: left !important;
        }

        #navCollapseUnico .nav-link-client-mobile {
            color: #fff !important;
            background: transparent !important;
            border-radius: 0 !important;
            text-align: left !important;
            padding: 8px 0 !important;
            margin: 0 !important;
            font-size: 14px !important;
            font-weight: 600 !important;
        }

        #navCollapseUnico .zp_container {
            width: 100% !important;
            margin: 12px 0 0 0 !important;
            border-radius: 35px !important;
            text-align: center !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
        }

        #navCollapseUnico .activeheader::after {
            display: none;
        }

        .language-dropdown-mobile {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 4px;
        }

        .language-dropdown-mobile .language-toggle {
            width: 100%;
            justify-content: space-between;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 35px;
            padding: 9px 14px;
            font-size: 14px;
        }

        .language-dropdown-mobile .language-menu {
            position: static !important;
            transform: none !important;
            width: 100%;
            margin-top: 7px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: none;
        }

        .language-dropdown-mobile .language-menu button {
            font-size: 14px;
        }

        .contMobile {
            margin-top: 10px;
            margin-bottom: 30px;
        }

        .contMobile div {
            padding-top: 5px !important;
        }

        .fotterM {
            width: 100% !important;
            height: auto !important;
        }

        .iconosF {
            width: 30px !important;
        }

        .botonesIg {
            margin-top: 50px !important;
        }

        .footerDiv {
            height: auto !important;
        }

        .box_container {
            width: 100% !important;
        }

        .inicoSlider {
            min-height: 500px !important;
            height: auto !important;
            padding: 80px 18px 50px 18px !important;
            width: 100% !important;
            margin-bottom: 0 !important;
        }

        .contenedorIm {
            min-height: 640px !important;
            height: auto !important;
        }

        .fundas {
            font-size: 40px !important;
            line-height: 48px !important;
            padding-top: 0 !important;
            margin-bottom: 18px !important;
        }

        .experiencia {
            font-size: 18px !important;
            line-height: 24px !important;
            max-width: 90% !important;
            margin-bottom: 20px !important;
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

    @media (max-width: 576px) {
        .newInicioPage,
        .contenedorIm,
        .headerComun {
            width: 100% !important;
        }

        .nav-unico {
            width: calc(100% - 40px) !important;
            max-width: calc(100% - 40px) !important;
            min-height: 72px;
        }

        .nav-unico .navbar-brand img {
            max-height: 58px;
        }

        .nav-unico .search-container {
            display: none;
        }

        #navCollapseUnico {
            width: 100% !important;
            right: auto !important;
            left: auto !important;
            border-radius: 0 !important;
            background: transparent !important;
        }

        #navCollapseUnico .navbar-nav {
            padding-top: 10px !important;
            padding-bottom: 16px !important;
        }

        #navCollapseUnico .nav-link {
            font-size: 13px !important;
            padding: 7px 0 !important;
        }

        #navCollapseUnico .nav-link-client-mobile {
            font-size: 13px !important;
            padding: 7px 0 !important;
        }

        #navCollapseUnico .zp_container {
            font-size: 13px !important;
            padding-top: 7px !important;
            padding-bottom: 7px !important;
        }

        .language-dropdown-mobile .language-toggle {
            font-size: 13px;
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .language-dropdown-mobile .language-menu button {
            font-size: 13px;
        }

        .inicoSlider {
            min-height: 500px !important;
            padding: 70px 16px 45px 16px !important;
        }

        .contenedorIm {
            min-height: 640px !important;
        }

        .fundas {
            font-size: 38px !important;
            line-height: 44px !important;
            max-width: 100% !important;
        }

        .experiencia {
            font-size: 16px !important;
            line-height: 22px !important;
            max-width: 100% !important;
        }

        .verProductosBoton {
            margin-top: 4px;
        }
    }

    @media (max-width: 400px) {
        .newInicioPage,
        .contenedorIm,
        .headerComun {
            width: 100% !important;
        }

        .nav-unico {
            width: calc(100% - 40px) !important;
            max-width: calc(100% - 40px) !important;
        }

        .navbar-brand {
            margin-right: 0px !important;
        }

        .img-fluid {
            max-width: 70% !important;
        }

        .botonesIg div {
            display: flex !important;
            gap: 0px !important;
        }

        .inicoSlider {
            min-height: 500px !important;
            padding-top: 60px !important;
        }

        .contenedorIm {
            min-height: 640px !important;
        }

        .fundas {
            font-size: 36px !important;
            line-height: 42px !important;
        }

        .experiencia {
            font-size: 15px !important;
            line-height: 21px !important;
        }
    }

    @media (max-width: 340px) {
        .newInicioPage,
        .contenedorIm,
        .headerComun {
            width: 100% !important;
        }

        .nav-unico {
            width: calc(100% - 28px) !important;
            max-width: calc(100% - 28px) !important;
        }

        .nav-unico .navbar-brand img {
            max-height: 52px;
        }

        #navCollapseUnico .nav-link {
            font-size: 12px !important;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
        }

        #navCollapseUnico .nav-link-client-mobile {
            font-size: 12px !important;
            padding-top: 6px !important;
            padding-bottom: 6px !important;
        }

        .fundas {
            font-size: 32px !important;
            line-height: 38px !important;
        }

        .experiencia {
            font-size: 14px !important;
            line-height: 20px;
        }
    }

    @media (min-width: 2400px) {
        .nav-unico {
            max-width: 1500px;
        }

        .box_container {
            width: 1500px !important;
        }
    }
</style>

{{-- Wrapper: con slider si es inicio, sin slider si no --}}
@if (@$headerinicio)
    <div class="container-fluid p-0 contenedorIm"
        style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%); background-size: cover; position: relative; overflow: hidden; height: 580px;">

        <div id="mediaContainer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
            <video id="sliderVideo" autoplay muted loop playsinline
                style="width: 100%; height: 100%; object-fit: cover; display: none;">
                <source id="videoSource" src="" type="video/mp4">
            </video>
            <img id="sliderImage" src="" alt="Slider Image"
                style="width: 100%; height: 100%; object-fit: cover; display: none;">
        </div>
        <div
            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1;">
        </div>
    @elseif (@$headerexpand)
        <div class="container-fluid sticky-top p-0 newInicioPage"
            style="z-index: 100; background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($empresa->fondoNavbar)) }}); background-size: cover;">
        @else
            <div class="container-fluid sticky-top p-0 headerComun"
                style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($empresa->fondoNavbar)) }}); background-size: cover;">
@endif

{{-- NAV ÚNICO --}}
<nav class="navbar navbar-expand-lg navbar-light p-0 nav-unico">

    {{-- LOGO --}}
    <a class="navbar-brand my-3 p-0" href="{{ route('page.inicio') }}">
        <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid">
    </a>

    {{-- LINKS DESKTOP --}}
    <div class="desktop-links d-none d-lg-flex align-items-center" style="height:100%; gap:4px;">
        @if (!Auth::guard('cliente')->check())
            <a class="nav-item nav-link mx-1 {{ $active == 'page.inicio' ? 'activeheader' : '' }} newnav-link"
                href="{{ route('page.inicio') }}">
                @if (session('locale') === 'es')
                    Inicio
                @else
                    Start
                @endif
            </a>
            <a class="btn py-1 px-4 newnav-link d-flex align-items-center" href="https://www.tytsa.com.ar/registro"
                style="color:#fff;border-radius:35px;margin-left:10px;font-weight:600;height:auto;">
                @if (session('locale') === 'es')
                    Convertite en cliente
                @else
                    Become a client
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

    {{-- ACCIONES DERECHA --}}
    <div class="d-flex align-items-center" style="gap:8px;">

        {{-- Buscador --}}
        <form method="POST" action="{{ route('page.productosSearch') }}" id="search-form">
            @csrf
            <div class="search-container">
                <input type="text" id="search-form-input" name="search" class="py-1 px-4"
                    style="width:144px;border-radius:35px;border:solid 2px #fff;background:none;color:#fff;"
                    @if (session('locale') === 'es') placeholder="Buscar" @else placeholder="Search" @endif>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </form>

        {{-- Login/Logout desktop --}}
        @if (!Auth::guard('cliente')->check())
            <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px;">
                @if (session('locale') === 'es')
                    Iniciar sesion
                @else
                    Login
                @endif
            </button>
        @else
            <button onclick="salir_clientes()" class="btn py-1 px-4 d-none d-lg-block" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px;">
                @if (session('locale') === 'es')
                    Cerrar sesion
                @else
                    Log out
                @endif
            </button>
        @endif

        {{-- Idioma desktop --}}
      <div class="dropdown language-dropdown d-none d-lg-block ms-1">
    <button class="language-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        @if (session('locale') === 'es')
            Español (ES)
        @else
            English (EN)
        @endif
    </button>

    <div class="dropdown-menu language-menu dropdown-menu-end">
        <form action="{{ route('changeIdioma') }}" method="POST">
            @csrf
            <input type="hidden" name="idioma" value="es">
            <button type="submit" class="{{ session('locale') === 'es' ? 'active' : '' }}">
                Español (ES)
            </button>
        </form>

        <form action="{{ route('changeIdioma') }}" method="POST">
            @csrf
            <input type="hidden" name="idioma" value="en">
            <button type="submit" class="{{ session('locale') === 'en' ? 'active' : '' }}">
                English (EN)
            </button>
        </form>
    </div>
</div>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler d-lg-none ms-1" type="button" data-bs-toggle="collapse"
            data-bs-target="#navCollapseUnico" aria-controls="navCollapseUnico" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    {{-- COLLAPSE MOBILE/TABLET --}}
    <div class="collapse" id="navCollapseUnico">
        <div class="navbar-nav d-flex flex-column mt-3 px-2 pb-3">
            @if (!Auth::guard('cliente')->check())
                <a class="nav-item nav-link {{ $active == 'page.inicio' ? 'activeheader' : '' }}"
                    href="{{ route('page.inicio') }}">
                    @if (session('locale') === 'es')
                        Inicio
                    @else
                        Start
                    @endif
                </a>
           <a class="nav-item nav-link nav-link-client-mobile" href="https://www.tytsa.com.ar/registro">
    @if (session('locale') === 'es')
        Convertite en cliente
    @else
        Become a client
    @endif
</a>
                <a class="nav-item nav-link {{ $active == 'page.empresa' ? 'activeheader' : '' }}"
                    href="{{ route('page.empresa') }}">
                    @if (session('locale') === 'es')
                        Quienes somos
                    @else
                        Who we are
                    @endif
                </a>
                <a class="nav-item nav-link {{ $active == 'page.productos' ? 'activeheader' : '' }}"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Productos
                    @else
                        Products
                    @endif
                </a>
                <a class="nav-item nav-link {{ $active == 'page.contacto' ? 'activeheader' : '' }}"
                    href="{{ route('page.contacto') }}">
                    @if (session('locale') === 'es')
                        Contacto
                    @else
                        Contact
                    @endif
                </a>
            @else
                <a class="nav-item nav-link {{ $active == 'page.productosCategorias' ? 'activeheader' : '' }}"
                    href="{{ route('page.productosCategorias') }}">
                    @if (session('locale') === 'es')
                        Catálogo
                    @else
                        Catalog
                    @endif
                </a>
                <a class="nav-item nav-link {{ $active == 'page.carrito' ? 'activeheader' : '' }}"
                    href="{{ route('page.carrito') }}">
                    @if (session('locale') === 'es')
                        Carrito
                    @else
                        Cart
                    @endif
                    <span id="cantidad-carrito-mobile">(0)</span>
                </a>
                <a class="nav-item nav-link {{ $active == 'page.historial' ? 'activeheader' : '' }}"
                    href="{{ route('page.historial') }}">
                    @if (session('locale') === 'es')
                        Historial
                    @else
                        Records
                    @endif
                </a>
                <a class="nav-item nav-link {{ $active == 'page.mi.perfil' ? 'activeheader' : '' }}"
                    href="{{ route('page.mi.perfil') }}">
                    @if (session('locale') === 'es')
                        Mi perfil
                    @else
                        My profile
                    @endif
                </a>
            @endif

       <div class="dropdown language-dropdown language-dropdown-mobile">
    <button class="language-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        @if (session('locale') === 'es')
            Español (ES)
        @else
            English (EN)
        @endif
    </button>

    <div class="dropdown-menu language-menu">
        <form action="{{ route('changeIdioma') }}" method="POST">
            @csrf
            <input type="hidden" name="idioma" value="es">
            <button type="submit" class="{{ session('locale') === 'es' ? 'active' : '' }}">
                Español (ES)
            </button>
        </form>

        <form action="{{ route('changeIdioma') }}" method="POST">
            @csrf
            <input type="hidden" name="idioma" value="en">
            <button type="submit" class="{{ session('locale') === 'en' ? 'active' : '' }}">
                English (EN)
            </button>
        </form>
    </div>
</div>

            @if (!Auth::guard('cliente')->check())
                <button class="btn zp_container py-1 px-4 mt-2" type="button"
                    style="color:#fff;background:#F15E40;border-radius:35px;">
                    @if (session('locale') === 'es')
                        Iniciar sesion
                    @else
                        Login
                    @endif
                </button>
            @else
                <button onclick="salir_clientes()" class="btn py-1 px-4 mt-2" type="button"
                    style="color:#fff;background:#F15E40;border-radius:35px;">
                    @if (session('locale') === 'es')
                        Cerrar sesion
                    @else
                        Log out
                    @endif
                </button>
            @endif
        </div>
    </div>

</nav>

{{-- HERO: solo en inicio --}}
@if (@$headerinicio)
    <div class="d-flex flex-column justify-content-center align-items-center inicoSlider"
        style="height: 374px; z-index: 2; margin-bottom: 20px;">
        <p class="box_container pt-5 fundas"
            style="font-weight:700;font-size:48px;line-height:58.56px;color:#fff;text-align:center;">
            {{ $bannerPrincipal[0]['titulo'] }}
        </p>
        <p class="box_container experiencia"
            style="font-weight:500;font-size:18px;line-height:23.4px;color:#fff;text-align:center;max-width:551px;">
            {{ $bannerPrincipal[0]['descripcion'] }}
        </p>
        <button class="btn py-1 px-4 verProductosBoton" type="button"
            onclick="window.location='{{ route('page.productosCategorias') }}'">
            @if (session('locale') === 'es')
                Ver Productos
            @else
                See Products
            @endif
        </button>
    </div>
@endif

{{-- TITLE: solo en expand (no inicio) --}}
@if (@$headerexpand && !@$headerinicio)
    <div class="d-flex justify-content-around align-items-center newInicioPageTwo" style="height:174px;">
        <p class="box_container pt-5"
            style="font-weight:600;font-size:32px;line-height:46.88px;color:#fff;text-align:center;">
            {{ $title }}
        </p>
    </div>
@endif

</div>

<script>
    function searchHandler(formId) {
        $(formId).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/buscar-productos',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.name + ' (' + item.code + ')',
                                value: item.name,
                                code: item.code,
                                codigoAnterior: item.codigoAnterior,
                                description: item.description
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $(this).val(ui.item.code);
                $(this).closest("form").submit();
            }
        });
    }

    searchHandler('#search-form-input');

    function contarProductosEnCarrito() {
        const obj_fila = localStorage.getItem('obj_fila');
        let cantidadTotal = 0;
        if (obj_fila) {
            try {
                const productos = JSON.parse(obj_fila);
                if (Array.isArray(productos) && productos.length > 0) {
                    cantidadTotal = productos.length;
                }
            } catch (error) {
                cantidadTotal = 0;
            }
        }
        $('#cantidad-carrito, #cantidad-carrito-mobile').text('(' + cantidadTotal + ')');
    }

    contarProductosEnCarrito();

    $('.navbar-toggler').click(function() {
        $('.navbar').toggleClass('bg-pc bg-mobile');
    });
</script>

@if (@$headerinicio)
    <script>
        const banners = @json($bannerPrincipal);
        let currentIndex = -1;

        function changeBanner() {
            currentIndex = (currentIndex + 1) % banners.length;
            const video = document.getElementById('sliderVideo');
            const videoSource = document.getElementById('videoSource');
            const image = document.getElementById('sliderImage');
            const title = document.querySelector('.fundas');
            const description = document.querySelector('.experiencia');

            video.style.display = 'none';
            image.style.display = 'none';

            if (banners[currentIndex].tipo === 'video') {
                videoSource.src = '{{ asset(Storage::url('')) }}/' + banners[currentIndex].imagen;
                video.load();
                video.style.display = 'block';
            } else {
                image.src = '{{ asset(Storage::url('')) }}/' + banners[currentIndex].imagen;
                image.style.display = 'block';
            }

            const locale = '{{ session('locale') }}';
            if (locale === 'es') {
                title.innerText = banners[currentIndex].titulo;
                description.innerText = banners[currentIndex].descripcion;
            } else {
                title.innerText = banners[currentIndex].tituloEnglish;
                description.innerText = banners[currentIndex].descripcionEnglish;
            }
        }

        if (banners.length > 1) {
            setInterval(changeBanner, 6000);
        }

        changeBanner();
    </script>
@endif
