@extends('layouts.plantilla')

@section('metadatos')
    <meta name="description" content="{{ $metadatos->descripcion }}" />
    <meta name="keywords" content="{{ $metadatos->keyword }}" />
@endsection

@section('content')
    <style>
        .embed-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .embed-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    <div class="d-flex justify-content-center align-items-center" style="background:#F4F4F4;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#000;text-align: start;">EMPRESA</p>
    </div>
    <div class="d-flex justify-content-center my-5">
        <div class="box_container d-flex justify-content-center align-items-start flex-wrap">
            <div class="col-12 col-md-6 p-0 px-5" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800">
                <div style="font-weight: bold;font-size:32px;">{{ $empresa->tituloDescripcion }}</div>
                <br>
                <div style="font-size: 16px;line-height: 25px;">{!! $empresa->descripcion !!}</div>
            </div>
            <div class="col-12 col-md-6 p-0 ps-md-1" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800">                
                    <img src="{{ asset(Storage::url($empresa->imagen)) }}" class="img-fluid">
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-center my-5" style="background:#F7F7F7;">
        <div class="box_container d-flex justify-content-between align-items-start flex-wrap py-5">
            <div class="row flex-wrap">
                <div class="col-md-4">
                    <div class="card py-3 h-100">
                        <div class="card-body">
                            <div style="height:54px;">
                                <img src="{{ asset(Storage::url($empresa->logo)) }}" class="d-block" alt="..." style="height: inherit;;">
                            </div>
                            <div class="d-flex justify-content-center flex-column py-2"
                                style="font-weight: 600;font-size:22px;">{{ $empresa->titulo }}</div>
                            <div class="d-flex justify-content-center flex-column">{!! $empresa->descripcion_logo !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-3 h-100">
                        <div class="card-body">
                            <div style="height:54px;">
                                <img src="{{ asset(Storage::url($empresa->logo_dos)) }}" class="d-block" alt="..." style="height: inherit;;">
                            </div>
                            <div class="d-flex justify-content-center flex-column py-2"
                                style="font-weight: 600;font-size:22px;">{{ $empresa->titulo_dos }}</div>
                            <div class="d-flex justify-content-center flex-column">{!! $empresa->descripcion_logo_dos !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card py-3 h-100">
                        <div class="card-body">
                            <div style="height:54px;">
                                <img src="{{ asset(Storage::url($empresa->logo_tres)) }}" class="d-block" alt="..." style="height: inherit;;">
                            </div>
                            <div class="d-flex justify-content-center flex-column py-2"
                                style="font-weight: 600;font-size:22px;">{{ $empresa->titulo_tres }}</div>
                            <div class="d-flex justify-content-center flex-column">{!! $empresa->descripcion_logo_tres !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.slick').slick({
                autoplay: true
            });
        });
    </script>
@endsection
