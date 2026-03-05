<!doctype html>
<html lang="es">

<head>
    
  


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://www.google.com/recaptcha/api.js?render=6LfTHjcgAAAAAGITE7V8RnEJSEewBzLe7YInxDHR"></script>    
    

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
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    <!--Alertify-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link href="{{ asset('css/plantilla.css?6') }}" rel="stylesheet">

    <!-- FOTORAMA -->
    <!-- jQuery 1.8 or later, 33 KB -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Fotorama from CDNJS, 19 KB -->
    <link href="{{asset('fotorama-4.6.4/fotorama.css')}}" rel="stylesheet">
    <!-- ANIMATION -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>    
    <!-- CLAVE SITIO WEB -->


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
            font-family: 'Ubuntu', sans-serif;
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
            width: 240px;
            height: 240px;
            cursor: pointer;

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
    
    <div id="app">
        @include('page.layouts.header')
        <main>
            @yield('content')
        </main>
        @include('page.layouts.footer')
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="{{asset('fotorama-4.6.4/fotorama.js')}}"></script>    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    


    <script>


    
        function search(element) {

            let input = element.previousElementSibling.value;
            console.log(element.previousElementSibling.value)
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
            $('#area_privada').toggle('ocultar_')
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
</body>

</html>
