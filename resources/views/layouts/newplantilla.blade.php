<!doctype html>
<html lang="es">

<head>

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-53RHLS4Z');</script>
<!-- End Google Tag Manager -->

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://www.google.com/recaptcha/api.js?render=6LdMkUAqAAAAAMX1k3itoW3VlVzFuJOkQTLvnSVF"></script>

    @yield('metadatos')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/b3aeabf072.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- FAVICON-->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <!--Alertify-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- FONT -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link href="{{ asset('css/plantilla.css?6') }}" rel="stylesheet">

    <!-- FOTORAMA -->
    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="{{ asset('fotorama-4.6.4/fotorama.css') }}" rel="stylesheet">
    <!-- ANIMATION -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- CLAVE SITIO WEB -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LdMkUAqAAAAAMX1k3itoW3VlVzFuJOkQTLvnSVF"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    
    <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '{your-pixel-id-goes-here}');
  fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none" 
       src="https://www.facebook.com/tr?id={your-pixel-id-goes-here}&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->


    <script>
        document.addEventListener('submit', function(e) {
            e.preventDefault();
            grecaptcha.ready(function() {
                //CLAVE SITIO WEB
                grecaptcha.execute('6LdMkUAqAAAAAMX1k3itoW3VlVzFuJOkQTLvnSVF', {
                    action: 'submit'
                }).then(function(token) {
                    let form = e.target;
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'g-recaptcha-response';
                    input.value = token;
                    form.appendChild(input);
                    form.submit();
                });
            });
        });
    </script>
    
    <script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '33656860503959745');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=33656860503959745&ev=PageView&noscript=1"
/></noscript>

    <title>TyT</title>
    @yield('style')
    @yield('recaptcha')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Encode+Sans:wght@100;200;300;400;500;600&family=Montserrat:wght@500;600;700&display=swap');

        .navbar-nav .nav-item .nav-link.active {
            border-bottom: 3px solid #B32B2D;
            padding-top: 25px;
            padding-bottom: 25px;
        }

        .nav-link {
            font-size: 15px;
        }

        .manualContainer {
            width: 281px;
            height: 282px;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .box_container {
            width: 100%;
        }

        .img-container {
            position: relative;
        }

        .img-container::after {
            width: 100%;
            height: 100%;
            z-index: 99;
            position: absolute;
            content: "";
            background: #034EA266;
        }

        .productoContainer {
            height: 368px !important;
            cursor: pointer;
        }

        .categoriaContainer {
            height: auto !important;
            cursor: pointer;
            justify-content: flex-end;
        }

        .equipoContainer {
            width: 300px;
            height: 130px;
        }

        .boxNovedad>* {
            width: 100%;
        }

        .boxNovedad img {
            width: 100%;
            height: auto;
        }

        .boxNovedad {
            position: relative;
        }

        .boxNovedad:hover:before {
            content: "+";
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            background: #D8D8D8;
            width: 70px;
            height: 70px;
            border-radius: 100%;
            opacity: 0.7;
            z-index: 99;
            color: #fff;
            position: absolute;
            left: 43%;
            top: 25%;
        }

        #area_privada {
            position: absolute;
            width: 295px;
            height: 315px;
            top: 15% !important;
            left: 80% !important;
            transform: translate(-50%, -50%);
            background: #f2f2f2;
            border-radius: 15px;
            z-index: 101;
        }

        .mobileProductos {
            display: none !important
        }

        @media (min-width: 600px) {
            .box_container {
                width: 800px;
            }

            /* .productoContainer{width: 186px;height: 186px;} */
            .equipoContainer {
                width: 300px;
                height: 130px;
            }

            .manualContainer {
                width: 181px;
                height: 182px;
            }

            .boxNovedad img {
                width: 266px;
                height: 212px;
            }

            .boxNovedad>* {
                width: 266px;
            }
        }

        @media (min-width: 1000px) {
            .box_container {
                width: 1200px;
            }


        }

        @media (max-width: 1000px) {

            .popL {
                padding-left: 0px !important;
                padding-right: 0px !important
            }

            #area_privada {
                left: 50% !important;
                top: 50% !important
            }

            .card-body {
                padding: 20px !important
            }

            .pcProductos {
                display: none !important
            }

            .mobileProductos {
                display: flex !important
            }
        }

        @media (min-width: 1250px) {
            .box_container {
                width: 1223px !important;
            }

            /* .productoContainer{
            width: 288px!important;
            height: 288px!important;
          } */
            .equipoContainer {
                width: 600px !important;
                height: 260px !important;
            }

            .boxNovedad img {
                width: 366px !important;
                height: 312px !important;
            }

            .boxNovedad>* {
                width: 366px !important;
            }

            .manualContainer {
                width: 285px !important;
                height: 282px !important;
            }
        }
    </style>
</head>

<body>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-53RHLS4Z"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <div id="app">

        @if (Auth::guard('cliente')->check())
            @include('page.layouts.newheader')
        @else
            @if (@$headerexpand)
                @if (@$headerinicio)
                    @include('page.layouts.newheaderexpandinicio')
                @else
                    @include('page.layouts.newheaderexpand')
                @endif
            @else
                @include('page.layouts.newheader')
            @endif
        @endif


        <main>

            <div id="area_privada" class="ocultar_"
                style="position:absolute;width:295px;height:315px;top:50%;right:13;z-index:101;background:white;border-radius:15px;right: 0;;left: 50%; transform: translateX(-50%);">
                <div class="container">
                    <div class="justify-content-center align-items-center">
                        <div class="col-md-12">
                            <div class="card-body px-0 pt-3">
                                @isset($msj)
                                    <div>{{ $msj }}</div>
                                @endisset

                                <form method="POST" action="{{ route('login.clientes') }}" autocomplete="off">
                                <!--<form method="POST"  autocomplete="off">-->
                                    @csrf
                                    <div class="mt-3 form-group row d-flex justify-content-center align-items-center">
                                        <div class="col-md-11 d-flex justify-content-between popL">
                                            <span style="color:#F15E40;font-size:20px;"><b>
                                                    @if (session('locale') === 'es')
                                                        INICIAR SESION
                                                    @else
                                                        LOGIN
                                                    @endif
                                                </b>
                                            </span>
                                            <button style="border: none; background:transparent; font-size: 20px"
                                                class="zp_container">X</button>

                                        </div>
                                        <div class="col-md-10 p-0">
                                            <span style="color:#000;font-size:16px;"><b>
                                                    @if (session('locale') === 'es')
                                                        Email
                                                    @else
                                                        Mail
                                                    @endif
                                                </b>
                                            </span>
                                            <input 
                                                style="background:transparent;color:#000;border-color:#F15E40; border-radius: 35px"
                                                id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" required
                                                autocomplete="username" autofocus>
                                        </div>
                                    </div>

                                    <div class="mt-3 form-group row d-flex justify-content-center align-items-center">
                                        <div class="col-md-10 p-0">
                                            <span style="color:#000;font-size:16px;"><b>
                                                    @if (session('locale') === 'es')
                                                        Contraseña
                                                    @else
                                                        Password
                                                    @endif
                                                </b>
                                            </span>
                                            <input 
                                                style="background:transparent;color:#000;border-color:#F15E40; border-radius: 35px"
                                                id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">
                                        </div>
                                    </div>

                                    <div
                                        class="mt-3 form-group row mb-0 d-flex justify-content-center align-items-center">
                                        <div
                                            class="col-md-10 d-flex flex-column justify-content-center align-items-center px-0">
                                            <button style="background:#F15E40;color: #fff;border-radius:35px;"
                                                type="submit" class="btn w-100">
                                                @if (session('locale') === 'es')
                                                    Ingresar
                                                @else
                                                    Login
                                                @endif
                                            </button>
                                            
                                              <!--<span clas="text-center">-->
                                                  
                                              <!--  @if (session('locale') === 'es')-->
                                              <!--      Acceso temporalmente deshabilitado.-->
                                              <!--  @else-->
                                              <!--      Access temporarily disabled.-->
                                              <!--  @endif-->
                                                  
                                              <!--</span>-->

                                            
                                            <a style="color: black !important" href="{{ route('page.registro') }}">
                                                @if (session('locale') === 'es')
                                                    Quiero ser cliente
                                                @else
                                                    I want to be a client
                                                @endif

                                            </a>
                                        </div>

                                    </div>
                                </form>
                                <div class="w-100 text-center d-none">
                                    {{-- <a href="{{ route('password') }}">Olvide mi contraseña</a> --}}
                                    <a href="{{ route('page.registro') }}">
                                        @if (session('locale') === 'es')
                                            Quiero ser cliente
                                        @else
                                            I want to be a client
                                        @endif
                                    </a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </main>
        @include('page.layouts.newfooter')

        
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{ asset('fotorama-4.6.4/fotorama.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
<script src="{{ asset('js/scriptP.js?v=9') }}"></script>

<script>
    window.eventosStoreUrl = '{{ route("eventos.store") }}';
    window.csrfToken = '{{ csrf_token() }}';
    window.clienteId = {{ Auth::guard('cliente')->user()->id ?? 'null' }};
  </script>

<script>
    (function(){
      // Solo se ejecuta si el cliente está autenticado (clienteId no es null)
      if(window.clienteId) {
        // Obtenemos la fecha de hoy en formato YYYY-MM-DD
        var today = new Date().toISOString().split("T")[0];
        // Creamos una clave única para el día actual
        var dailyKey = 'cliente_referrer_' + today;
        
        // Si no se ha registrado el referrer hoy, lo enviamos
        if(!localStorage.getItem(dailyKey)) {
          $.ajax({
            url: window.eventosStoreUrl,
            type: 'POST',
            data: {
              cliente_id: window.clienteId,
              tipo_evento: 'cliente_referrer',
              fecha: new Date().toISOString(),
              referrer: document.referrer
            },
            headers: {
              'X-CSRF-TOKEN': window.csrfToken
            },
            success: function(response) {
              console.log('Evento cliente_referrer guardado en la BD', response);
              // Marcamos que ya se registró el evento hoy
              localStorage.setItem(dailyKey, 'true');
            },
            error: function(xhr, status, error) {
              console.error('Error al guardar el evento cliente_referrer', error);
            }
          });
        }
      }
    })();
  </script>
  
  
    @stack('scripts')

    <script>
 window.onload = function() {
    if (window.myCartModule && typeof window.myCartModule.checkCartAbandonment === 'function') {
      window.myCartModule.checkCartAbandonment();
    } else {
      console.log('myCartModule no est��� definido');
    }
  };


        $('.navbar-toggler').click(function() {
            console.log('hola')
            $('.navbar').toggleClass('bg-pc bg-mobile');
        });



  



        





        function search(element) {

            let input = element.previousElementSibling.value;
            console.log(element.previousElementSibling.value, '?????')
            //window.location.href = "/_euma/search/"+input;            

        }

        function mostrar() {
            let id = "boxBuscador"

            document.getElementById(id).style.visibility = "hidden";
            document.getElementById(id).style.visibility = "visible";

        }
        $('.btnBuscador').click(function() {
            $('#boxBuscador').toggle('ocultar_')
        });
        $('.btnOcultar').click(function() {
            $('#boxOcultar').toggle('ocultar_')
        });
        $('.zp_container').click(function() {
            console.log('click')
            $('#area_privada').toggle('ocultar_');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        function salir_clientes() {
            // sessionStorage.removeItem('obj_fila');
            window.location.href = '{{ route('salir') }}';
        }
    </script>
    <script>
        AOS.init();
    </script>
    @yield('js')
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
</body>

</html>
