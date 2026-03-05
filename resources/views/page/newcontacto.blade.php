@extends('layouts.newplantilla')
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











@media (max-width: 1000px) {

   

    .mapasContacto{
                flex-direction: column !important;
            }
    .newContactoT{
        height: auto !important;
    }

.contenedorC{
    width: 100% !important;
}

.containerEmpresa {
    display: none !important
}

.imgTexto{
    display: flex;
    flex-direction: column !important
}

.frameM{
    width: 100% !important;
    height: 400px !important;
}

.cajaM{
    margin-top: 20px !important;
    height: 800px !important;

}

.containerMobile{
    display: flex !important;
    flex-direction: column !important;
    height: auto !important;

}



}

@media (max-width: 320px) {
    .contactoM{
        flex-direction: column !important
    }

    .cajaM{
        height: auto !important;
    }

}
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
    <div class="d-flex justify-content-center align-items-end newContactoT" style="background:#FFF;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#000;text-align: center;">
            @if(session('locale') === 'es')
            Contacto                                @else
            Contact
            @endif
            
            </p>
    </div>
    <div class="d-flex justify-content-center align-items-center p-2" style="background:#FFF;">
        <p>

            @if(session('locale') === 'es')
            Para mayor información, no dude en contactarse mediante el siguiente formulario, o a través de nuestras vías de comunicación.
            @else
            For more information, please do not hesitate to contact us using the following form, or through our communication channels.
            @endif
        </p>
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
                    <div class="col-md-12 my-4">
                        <form data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800" method="post"
                            id="form" action="{{ route('page.contacto.post') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 ">
                                    <label>

                                        @if(session('locale') === 'es')
                                        Nombre y apellido*                                @else
                                        First and last name*
                                        @endif

                                    </label>
                                        <input type="text" class="form-control bordercont" id="nombre" name="nombre"
                                            required >
                                    
                                </div>
                                <div class="col-md-6 ">
                                    <label>E-Mail*</label>
                                        <input type="email" class="form-control bordercont" id="email" name="email"
                                            required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    <label>


                                        
                                        @if(session('locale') === 'es')
                                        Teléfono                                @else
                                        Phone
                                        @endif
                                    </label>
                                        <input type="text" class="form-control bordercont" id="telefono" name="telefono"
                                            required >
                                    </label>
                                </div>
                                <div class="col-md-6 mt-4">
                                    <label>      @if(session('locale') === 'es')
                                        Empresa                                @else
                                        Company
                                        @endif</label>
                                        <input type="text" class="form-control bordercont" id="empresa" name="empresa"
                                            required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mt-4">
                                        <label>      @if(session('locale') === 'es')
                                            Mensaje*
                                            @else
                                            Message*
                                            @endif</label>
                                    <textarea class="form-control bordercont" id="mensaje" name="mensaje" rows="6" cols="10">
                                    </textarea>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group ">
                                        <div id="recaptcha"></div>
                                        <input type="hidden" name="recaptcha" id="recaptcha">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-center mt-4 contactoM">
                                <p class="m-0 pe-4" style="font-size:18px;color:#131313;">

                                    @if(session('locale') === 'es')
                                    * campos obligatorios                                @else
                                    * required fields
                                            @endif




                                </p>
                                <button type="submit" class="btn btn-ficha font-weight-bold px-5 float-right"
                                    style="font-size: 18px;border-radius:35px;">

                                    @if(session('locale') === 'es')
                                    Enviar mensaje                                @else
                                    Send message
                                            @endif
                                </button>
                                </div>
                            <span id="mensaje-contacto" style="color: green"></span>
                            <span id="mensaje-contacto-error" style="color: red"></span>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-flex justify-content-center">
        <div class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap box_container py-5">
            @foreach ($contactos as $contacto)
                <div class="col-lg-6 d-flex cajaM" >
                    <div class="d-flex mapasContacto">
                        <div class="frameM">
                            <div data-aos="zoom-in" class="gmap_canvas">
                                <iframe width="100%" height="400" id="gmap_canvas"
                                    src="https://maps.google.com/maps?q={{ $contacto->direccionMap() }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    {{-- src="https://maps.google.com/maps?q=Monte...%-%C1239%AAD%,%Buenos%Aires%,%Argentina&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                    src="https://maps.google.com/maps?q=Monte...%20-%20C1239%20AAD%20,%20Buenos%20Aires%20,%20Argentina&t=&z=13&ie=UTF8&iwloc=&output=embed" --}} frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                                </iframe>
                                <br>
                                <style>
                                    .mapouter {
                                        position: relative;
                                        text-align: right;
                                        height: 400px;
                                        width: 100%;
                                    }
                                </style>
                                <a href="https://www.embedgooglemap.net">google map responsive</a>
                                <style>
                                    .gmap_canvas {
                                        overflow: hidden;
                                        background: none !important;
                                        height: 400px;
                                        width: 100%;
                                    }
                                </style>
                            </div>
                        </div>

                        <div class="col-lg-6 p-4 mr-1 d-flex flex-column justify-content-between"
                            style="background-color:#F15E40;color:#fff;">
                            <div class="row justify-content-start">
                                <span class="name">

                                    @if(session('locale') === 'es')
                                    {{ $contacto->name }}
                                    @else
                                    {{ $contacto->nameEnglish }}
                                    @endif




                                </span>
                            </div>
                            <div class="row justify-content-start" style="padding-top: 16px !important">
                                <span class="descripcion">
                                    @if(session('locale') === 'es')
                                    {{ $contacto->descripcion }}
                                    @else
                                    {{ $contacto->descripcionEnglish }}
                                    @endif

                                </span>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col-xl-1 col-lg-1 col-md-2 col-sm-1 col-2 my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="18"
                                        viewBox="0 0 13 18" fill="none">
                                        <path
                                            d="M5.83177 16.9802C0.913195 9.85178 0 9.12058 0 6.49961C0 4.77581 0.684778 3.1226 1.90369 1.90369C3.1226 0.684778 4.77581 0 6.49961 0C8.22341 0 9.87661 0.684778 11.0955 1.90369C12.3144 3.1226 12.9992 4.77581 12.9992 6.49961C12.9992 9.12058 12.086 9.85178 7.16744 16.9802C7.09267 17.0882 6.99286 17.1763 6.87655 17.2373C6.76024 17.2982 6.6309 17.33 6.49961 17.33C6.36831 17.33 6.23898 17.2982 6.12267 17.2373C6.00636 17.1763 5.90655 17.0882 5.83177 16.9802ZM6.49961 9.20751C7.03518 9.20751 7.55873 9.04869 8.00404 8.75115C8.44935 8.4536 8.79643 8.03068 9.00138 7.53588C9.20634 7.04107 9.25996 6.49661 9.15548 5.97132C9.05099 5.44604 8.79309 4.96354 8.41438 4.58484C8.03568 4.20613 7.55318 3.94823 7.02789 3.84374C6.50261 3.73926 5.95815 3.79288 5.46334 3.99784C4.96854 4.20279 4.54562 4.54987 4.24807 4.99518C3.95053 5.44049 3.79171 5.96404 3.79171 6.49961C3.79171 7.21779 4.07701 7.90655 4.58484 8.41438C5.09267 8.92221 5.78143 9.20751 6.49961 9.20751Z"
                                            fill="white" />
                                    </svg>
                                </div>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-11 col-10 my-2 justify-content-start"
                                    style="text-align:justify">
                                    <a class="link"
                                        target="_blank" style="color:#fff; font-size:14px">
                                        {{ $contacto->direccion }}
                                    </a>
                                </div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12"
                                        viewBox="0 0 16 12" fill="none">
                                        <path
                                            d="M15.7 3.963C15.7277 3.94244 15.7605 3.9299 15.7949 3.92675C15.8292 3.9236 15.8638 3.92997 15.8948 3.94514C15.9257 3.96032 15.9519 3.98373 15.9705 4.01281C15.9891 4.04189 15.9993 4.07551 16 4.11V10.5C16 10.8978 15.842 11.2794 15.5607 11.5607C15.2794 11.842 14.8978 12 14.5 12H1.5C1.10218 12 0.720644 11.842 0.43934 11.5607C0.158035 11.2794 0 10.8978 0 10.5L0 4.113C0.000368432 4.07836 0.0103538 4.0445 0.0288422 4.0152C0.0473307 3.9859 0.0735953 3.96231 0.104707 3.94707C0.135818 3.93182 0.170552 3.92552 0.205036 3.92886C0.23952 3.93221 0.272397 3.94507 0.3 3.966C1 4.51 1.928 5.2 5.116 7.516C5.778 8 6.891 9.009 8 9C9.116 9.009 10.25 7.975 10.884 7.513C14.072 5.2 15 4.506 15.7 3.963ZM8 8C8.725 8.013 9.769 7.088 10.294 6.706C14.441 3.697 14.756 3.434 15.713 2.684C15.8025 2.61393 15.8749 2.52438 15.9246 2.42215C15.9744 2.31992 16.0001 2.20769 16 2.094V1.5C16 1.10218 15.842 0.720643 15.5607 0.439339C15.2794 0.158034 14.8978 0 14.5 0H1.5C1.10218 0 0.720644 0.158034 0.43934 0.439339C0.158035 0.720643 0 1.10218 0 1.5L0 2.094C0.000118744 2.20789 0.0261037 2.32026 0.0759939 2.42264C0.125884 2.52502 0.198376 2.61473 0.288 2.685C1.244 3.432 1.56 3.698 5.707 6.707C6.231 7.088 7.275 8.013 8 8Z"
                                            fill="white" />
                                    </svg>
                                </div>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 my-2" style="text-align:justify">
                                    <a class="link" href="mailto:{{ $contacto->email }}"
                                        style="color:#fff; font-size:14px">
                                        {{ $contacto->email }}</a>
                                </div>
                            </div>
                            <div class="row justify-content-start">
                                <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16" fill="none">
                                        <path
                                            d="M15.544 11.3069L12.044 9.80685C11.8944 9.74317 11.7282 9.72981 11.5704 9.76876C11.4126 9.80772 11.2717 9.89689 11.169 10.0229L9.619 11.9169C7.18597 10.7699 5.22798 8.81188 4.081 6.37885L5.975 4.82885C6.10123 4.72631 6.1906 4.58543 6.22958 4.42754C6.26856 4.26965 6.25501 4.10335 6.191 3.95385L4.691 0.453852C4.62081 0.292487 4.49646 0.160708 4.33944 0.0812825C4.18241 0.00185718 4.00258 -0.0202247 3.831 0.0188522L0.581 0.768852C0.415776 0.807065 0.26838 0.900146 0.162862 1.03291C0.0573448 1.16567 -6.52211e-05 1.33027 5.56045e-08 1.49985C5.56045e-08 5.34549 1.52767 9.03362 4.24695 11.7529C6.96623 14.4722 10.6544 15.9999 14.5 15.9999C14.6696 15.9999 14.8342 15.9425 14.9669 15.837C15.0997 15.7315 15.1928 15.5841 15.231 15.4189L15.981 12.1689C16.0198 11.9965 15.9973 11.816 15.9174 11.6585C15.8374 11.501 15.705 11.3762 15.543 11.3059L15.544 11.3069Z"
                                            fill="white" />
                                    </svg>
                                </div>
                                <div class="col-xl-10 col-lg-10 col-md-10 col-sm-11 col-10  my-2 pe-5"
                                    style="text-align:justify">
                                    <a class="link" href="tel:{{ $contacto->telefono }}"
                                        style="color:#fff; font-size:14px">
                                        {{ $contacto->telefono }}</a>
                                </div>
                            </div>
                        </div>


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
            grecaptcha.execute('6LdMkUAqAAAAAMX1k3itoW3VlVzFuJOkQTLvnSVF', {action: 'formulario'}).then(function (token) {
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

                    $('#mensaje-contacto').html(response)
                },
                error: function(response) {
                    console.log(response);
                    $('#mensaje-contacto-error').html(response)

                }
            });
        });
    </script>
@endsection
