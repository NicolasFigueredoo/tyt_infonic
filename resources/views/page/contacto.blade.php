@extends('layouts.plantilla')
@section('recaptcha')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! htmlScriptTagJsApi([
        'action' => 'homepage',
    ]) !!}
@endsection
@section('metadatos')
    <meta name="description" content="{{ $metadatos->descripcion }}" />
    <meta name="keywords" content="{{ $metadatos->keyword }}" />
@endsection
@section('content')
    <style type="text/css">


        .iconocom {
            color: #000;
        }

        .titulo_contacto {
            font-weight: 600;
            font-size: 13px;
            color: #ED1C24;
        }

        .letracont {
            font-size: 16px;
            color: #000000;
        }

        .link:hover {
            color: #858592;
            text-decoration: none;
        }

        .bordercont {
            border: 1px solid #D2D2D2 !important;
        }

        input::placeholder {
            font-size: 14px;
            color: #8D8D8D;

        }

        textarea::placeholder {
            font-size: 14px;
        }

        .btn-ficha {
            color: #fff;
            background-color: #F15E40;
            border-color: #F15E40;
        }

        .btn-ficha:hover {
            color: #F15E40;
            background-color: white;
            border-color: #F15E40;

        }
    </style>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @isset($obj)
        <div class="ms-5 my-5">
            {!! $obj->respuesta !!}
        </div>
    @endisset
    <div class="d-flex justify-content-center align-items-center contactoView" style="background:#F5F5F5;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#F15E40;text-align: start;">Contacto</p>
    </div>
    <div class="d-flex justify-content-center my-3">
        <div class="d-flex justify-content-center box_container">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @isset($obj)
                <div class="ms-5 my-5">
                    {!! $obj->respuesta !!}
                </div>
            @endisset

            <div class="container-fluid px-4 py-4">
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <div class="row">
                            <div data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800" class="col-12">
                                <div class="row">
                                <span>Para mayor información, no dude en contactarse mediante el siguiente formulario, o a través de nuestras vías de comunicación.</span>
                                    @foreach ($contactos as $contacto)
                                        <span style="font-size:16px;" class="pb-3">{{ $contacto->name }}</span>
                                        <div class="col-xl-1 col-lg-1 col-md-2 col-sm-1 col-2 my-2">
                                            <i style="color:#F15E40;" class="iconocom fas fa-map-marker-alt fa-lg"></i>
                                        </div>

                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-11 col-10 my-2">
                                            <a class="link"
                                                href="https://www.google.com/maps/place/Indalecio+G%C3%B3mez+3951,+Villa+Lynch,+Provincia+de+Buenos+Aires/data=!4m2!3m1!1s0x95bcb7b98e58e3e5:0x733f16804e76771?sa=X&ved=2ahUKEwi97efS_or8AhWtq5UCHYeRBVsQ8gF6BAgIEAE"
                                                target="_blank">
                                                <span class="letracont">{{ $contacto->direccion }}</span></a>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2">
                                            <i style="color:#F15E40;" class="iconocom far fa-envelope fa-lg"></i>
                                        </div>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-10 col-10 my-2">
                                            <a class="link" href="mailto:{{ $contacto->email }}">
                                                <span class="letracont">{{ $contacto->email }} </span></a>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2">
                                            <i style="color:#F15E40;" class="iconocom fas fa-phone-alt fa-lg"></i>
                                        </div>
                                        <div class="col-xl-11 col-lg-10 col-md-10 col-sm-11 col-10  my-2 pe-5">
                                            <a class="link" href="tel:{{ $contacto->telefono }}">
                                                <span class="letracont"
                                                    style="word-break: break-word;">{{ $contacto->telefono }} </span></a>
                                        </div>
                                        @isset($contacto->wsp)
                                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2">
                                                <i style="color:#F15E40;" class="fab fa-whatsapp fa-lg"></i>
                                            </div>
                                            <div class="col-xl-11 col-lg-10 col-md-10 col-sm-11 col-10  my-2">
                                                <a class="link" href="tel:{{ $contacto->wsp }}">
                                                    <span class="letracont">{{ $contacto->wsp }} </span></a>
                                            </div>
                                        @endisset
                                    @endforeach
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 my-4">
                        <form data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800" method="post"
                            id="form" action="{{ route('page.contacto.post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control bordercont" id="nombre" name="nombre"
                                        required placeholder="Nombre y apellido*">
                                </div>
                                <div class="col-md-6 ">
                                    <input type="email" class="form-control bordercont" id="email" name="email"
                                        required placeholder="E-Mail*">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    <input type="text" class="form-control bordercont" id="telefono" name="telefono"
                                        required placeholder="Teléfono">
                                </div>
                                <div class="col-md-6 mt-4">
                                    <input type="text" class="form-control bordercont" id="empresa" name="empresa"
                                        required placeholder="Empresa">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                    <textarea class="form-control bordercont" id="mensaje" name="mensaje" rows="6" cols="10"
                                        placeholder="Mensaje*"></textarea>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <div id="recaptcha"></div>
                                        <input type="hidden" name="recaptcha" id="recaptcha">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <p class="m-0 pe-4" style="font-size:18px;color:#131313;">* campos obligatorios</p>
                                <button type="submit" class="btn btn-ficha font-weight-bold px-5 float-right"
                                    style="font-size: 18px;border-radius:35px;">Enviar mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-3 justify-content-center">
        <div class="mapouter box_container my-3 d-flex flex-row flex-wrap">
        @foreach ($contactos as $contacto)
        <div class="col-6 px-2">
                <div data-aos="zoom-in" class="gmap_canvas">
                    <iframe width="100%" height="350" id="gmap_canvas"
                        src="https://maps.google.com/maps?q={{ $contacto->direccionMap() }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        {{-- src="https://maps.google.com/maps?q=Monte...%-%C1239%AAD%,%Buenos%Aires%,%Argentina&t=&z=13&ie=UTF8&iwloc=&output=embed"
            src="https://maps.google.com/maps?q=Monte...%20-%20C1239%20AAD%20,%20Buenos%20Aires%20,%20Argentina&t=&z=13&ie=UTF8&iwloc=&output=embed" --}} frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"></iframe><a href="https://youtube-embed-code.com">youtube embed code</a><br>
                    <style>
                        .mapouter {
                            position: relative;
                            text-align: right;
                            height: 350px;
                            width: 100%;
                        }
                    </style>
                    <a href="https://www.embedgooglemap.net">google map responsive</a>
                    <style>
                        .gmap_canvas {
                            overflow: hidden;
                            background: none !important;
                            height: 350px;
                            width: 100%;
                        }
                    </style>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--Alertify-->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6LfTHjcgAAAAAGITE7V8RnEJSEewBzLe7YInxDHR', {action: 'formulario'}).then(function (token) {
                document.getElementById('recaptcha').value = token;
            });
        });
    </script>
    
    <script>        
        ///ENVIO AJAX
        $('#form').on('submit', function(e) {
            e.preventDefault();
            data = new FormData();
            data.append('nombre', document.getElementById("nombre").value);
            data.append('email', document.getElementById("email").value);
            data.append('telefono', document.getElementById("telefono").value);
            data.append('empresa', document.getElementById("empresa").value);
            data.append('mensaje', document.getElementById("mensaje").value);
            data.append('_token', document.querySelector('[name="_token"]').value);
            $.ajax({
                url: '{{ route('page.contacto.post') }}',
                data: data,
                type: "post",
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType      
                success: function(response) {
                    swal(response, "", "success");
                },
                error: function(response) {
                    console.log(response);
                    swal("Algo salió mal", "", "error");
                }
            });
        });
    </script>
@endsection
