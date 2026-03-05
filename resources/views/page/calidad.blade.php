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
    
    <div class="d-flex justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#0E7D4A;text-align: center;">Calidad</p>
    </div>
    <div class="d-flex justify-content-center my-5">
        <div class="box_container d-flex justify-content-center align-items-start flex-wrap">
            <div class="col-12 col-md-6 p-0 pe-md-1" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800">
                <div style="font-weight:600;font-size:32px;">{{ $calidad->tituloDescripcion }}</div>
                <br>
                {!! $calidad->descripcion !!}
            </div>
            <div class="col-12 col-md-6 p-0 ps-md-1" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800">
                <div class="embed-container">
                    <img src="{{ asset(Storage::url($calidad->imagen)) }}">
                </div>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-center my-5" style="background:#F7F7F7;">
        <div class="box_container d-flex justify-content-between align-items-start flex-wrap py-5">
            <div class="row flex-wrap col-12">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body d-flex flex-row justify-content-start align-items-center">
                            <div style="height:126px;background:#fff;" class="d-flex justify-content-start align-items-center px-2">
                                <img src="{{ asset(Storage::url($calidad->logo)) }}" class="d-block" width="98px" height="98px">
                            </div>
                            <div class="d-flex justify-content-between w-100 px-3">
                                <div class="d-flex justify-content-center flex-column">{!! $calidad->descripcionCertificado !!}</div>
                                <a style="text-decoration: none;" href="{{asset(Storage::url($calidad->certificado))}}">
                                    <img src="{{asset('images/dwld.svg')}}">
                                </a>
                            </div>                                                
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body d-flex flex-row justify-content-start align-items-center">
                            <div style="height:126px;background:#fff;" class="d-flex justify-content-start align-items-center px-2">
                                <img src="{{ asset(Storage::url($calidad->logoDos)) }}" class="d-block" width="98px" height="98px">
                            </div>                                    
                            <div class="d-flex justify-content-between w-100 px-3">
                                <div class="d-flex justify-content-center flex-column">{!! $calidad->descripcionCertificadoDos !!}</div>
                                <a style="text-decoration: none;" href="{{asset(Storage::url($calidad->certificadoDos))}}">
                                    <img src="{{asset('images/dwld.svg')}}">
                                </a>
                            </div>                    
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
