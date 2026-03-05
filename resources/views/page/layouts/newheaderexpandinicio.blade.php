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
        color: #ffff;
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

    .novedadHover:hover {
        transform: scale(1.03);
        transition: all 0.5s ease 0.2s;
    }

    .newnav-link {
        color: #fff;
        font-weight: 600;
        height: 100% !important;
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

    .bg-pc {
        background: transparent !important;
    }

    .bg-mobile {
        background-color: black !important;
    }


    .mobileContant {
        display: none !important;
    }

    @media (max-width: 308px) {

        .inicoSlider {
            height: 750px !important;
        
        }
        .contenedorIm{
            height: 750px !important;
        }

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
.contenedorIm{
    height: 640px !important;
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

        .inicoSlider {
            height: 800px !important;
        
        }
        .contenedorIm{
            height: 800px !important;
        }



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
   @media (min-width: 2400px) {
        .box_container{
            width: 1500px !important;
        }
    }
   
</style>




<div class="container-fluid d-flex justify-content-center flex-wrap p-0 contenedorIm"
    style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%); background-size: cover; position: relative; overflow: hidden;     height: 580px;">
    
    <div id="mediaContainer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;">
        <video id="sliderVideo" autoplay muted loop playsinline
            style="width: 100%; height: 100%; object-fit: cover; display: none;">
            <source id="videoSource" src="" type="video/mp4">
            Tu navegador no soporta la etiqueta de video.
        </video>
        
        <img id="sliderImage" src="" alt="Slider Image" style="width: 100%; height: 100%; object-fit: cover; display: none;">
    </div>

    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

    <nav class="navbar navbar-expand-lg navbar-light p-0 box_container justify-content-between navOld"
    style="z-index: 2;border-bottom: 1px solid white;">
    <div class="d-flex flex-wrap flex-row justify-content-between align-items-center">
        <a class="navbar-brand my-3 p-0" href="{{ route('page.inicio') }}">
            <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid ">
        </a>
    </div>
    <div class="d-flex align-items-center d-none d-lg-flex" style="height:100%">
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
    </div>

    <div class="d-flex align-items-center d-lg-none">
        <button class="navbar-toggler mb-2 " type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-column align-items-center" id="navbarNavAltMarkup">
            <div class="navbar-nav  d-flex justify-content-between ml-auto mt-3 w-100">

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
        <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">

            @if (session('locale') === 'es')
                Iniciar sesion
            @else
                Login
            @endif

        </button>

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
        <a class="navbar-brand my-3 p-0" href="{{ route('page.inicio') }}">
            <img src="{{ asset(Storage::url('logo/logo.png')) }}" class="img-fluid ">
        </a>
    </div>
    <div class="d-flex align-items-center d-none d-lg-flex" style="height:100%">
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
        <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
            @if (session('locale') === 'es')
                Iniciar sesion
            @else
                Login
            @endif


        </button>
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
            <button class="btn zp_container py-1 px-4" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                @if (session('locale') === 'es')
                    Iniciar sesion
                @else
                    Login
                @endif
            </button>
        </div>
    </div>


</nav>

<nav class="navbar navbar-expand-lg navbar-light p-0 box_container justify-content-around navMobile"
    style="z-index: 2; border-bottom: 1px solid white;">
    <div class="d-flex flex-wrap flex-row justify-content-between align-items-center">
        <a class="navbar-brand my-3 p-0" href="{{ route('page.inicio') }}">
            <img src="{{ asset(Storage::url($logosheader->image)) }}" class="img-fluid ">
        </a>
    </div>
    <div class="d-flex align-items-center d-none d-lg-flex" style="height:100%">
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
                <input type="text" id="search-form-tablet" name="search" class="py-1 px-4"
                    style="width:144px;border-radius:35px; border: solid 2px #fff; background: none; color: #fff;"
                    @if (session('locale') === 'es') placeholder="Buscar"    
            @else
             placeholder="Search" @endif>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
        </form>
        <button class="btn zp_container py-1 px-4 d-none d-lg-block" type="button"
            style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
            @if (session('locale') === 'es')
                Iniciar sesion
            @else
                Login
            @endif
        </button>
    </div>



    <div class="collapse navbar-collapse flex-column align-items-center mt-4" id="navbarNavAltMarkup">
        <div class="navbar-nav d-flex justify-content-between">

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
            <button class="btn zp_container py-1 px-4" type="button"
                style="color:#fff;background:#F15E40;border-radius:35px; margin-left: 10px;">
                @if (session('locale') === 'es')
                    Iniciar sesion
                @else
                    Login
                @endif
            </button>
        </div>
    </div>
</nav>

    <div class="d-flex flex-column justify-content-center align-items-center inicoSlider"
        style="height: 374px; z-index: 2; margin-bottom: 20px;">
        
        <p class="box_container pt-5 fundas"
            style="font-weight: 700; font-size: 48px; line-height: 58.56px; color: #fff; text-align: center;">
            {{ $bannerPrincipal[0]['titulo'] }}
        </p>
        
        <p class="box_container experiencia"
            style="font-weight: 500; font-size: 18px; line-height: 23.4px; color: #fff; text-align: center; max-width: 551px;">
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
                        // Procesar los resultados y formatearlos para el autocomplete
                        response($.map(data, function(item) {
                            return {
                                label: item.name + ' (' + item.code +
                                    ')', // Lo que se muestra en el dropdown
                                value: item
                                    .name, // Valor seleccionado al hacer clic
                                code: item.code, // Código del producto
                                codigoAnterior: item.codigoAnterior,
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


    $('.navbar-toggler').click(function() {
        $('.navbar').toggleClass('bg-pc bg-mobile');
    });
</script>


<script>
    const banners = @json($bannerPrincipal);
    let currentIndex = -1;

    function changeBanner() {
        currentIndex = (currentIndex + 1) % banners.length; // Cambia al siguiente índice, vuelve al inicio si es el final
        const video = document.getElementById('sliderVideo');
        const videoSource = document.getElementById('videoSource');
        const image = document.getElementById('sliderImage');
        const title = document.querySelector('.fundas');
        const description = document.querySelector('.experiencia');

        // Limpia el contenido anterior
        video.style.display = 'none';
        image.style.display = 'none';

        // Verifica si el elemento actual es un video o una imagen


        if (banners[currentIndex].tipo === 'video') {
            videoSource.src = '{{ asset(Storage::url('')) }}/' + banners[currentIndex].imagen; // Ruta del video
            video.load(); // Carga el video
            video.style.display = 'block'; // Muestra el video
        } else {
            image.src = '{{ asset(Storage::url('')) }}/' + banners[currentIndex].imagen; // Ruta de la imagen
            image.style.display = 'block'; // Muestra la imagen
        }

        // Cambia el título y la descripción según el locale
        const locale = '{{ session('locale') }}';
        if (locale === 'es') {
            title.innerText = banners[currentIndex].titulo;
            description.innerText = banners[currentIndex].descripcion;
        } else {
            title.innerText = banners[currentIndex].tituloEnglish;
            description.innerText = banners[currentIndex].descripcionEnglish;
        }
    }

    // Cambia de banner cada 3 segundos

    if (banners.length > 1) {
        setInterval(changeBanner, 6000); // Cambia cada 6 segundos
    }

    changeBanner(); // Llama a la función al cargar para mostrar el primer banner
</script>




