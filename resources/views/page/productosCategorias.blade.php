@extends('layouts.plantilla')
@section('metadatos')
    <meta name="description" content="{{ $metadatos->descripcion }}" />
    <meta name="keywords" content="{{ $metadatos->keyword }}" />
@endsection


@section('content')
    <style>
        .accordion-button.collapsed {
            background: transparent;
        }

        .box_hover {
            position: relative;
        }

        /* .box_hover:hover img{
      -webkit-transform: scale(1.05);
        transform: scale(1.05);
        transition: all 0.5s ease 0.2s;
        position: relative;
        z-index: 100;
    } */
        .box_hover:hover:before {
            content: "+";
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            background: #D8D8D8;
            width: 94px;
            height: 94px;
            border-radius: 100%;
            opacity: 0.7;
            z-index: 99;
            color: #fff;
            position: absolute;
        }

        .box_description>* {
            color: #717171 !important;
            font-size: 18px !important;
        }
    </style>
    <div class="d-flex justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#000;text-align: start;">Cat&aacute;logo</p>
    </div>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap box_container py-5">
            {{-- PRODUCTOS DESTACADOS --}}
            @forelse ($categorias as $item)
                <div id="boxProducto"
                    class="col-12 col-md-6 d-fex flex-column justify-content-center align-items-center align-items-md-start mb-5"
                    style="position: relative;text-transform:uppercase;border-radius: 0px;" data-aos="zoom-in">
                    <div class="d-flex flex-column justify-content-start align-items-center"
                        style="cursor:pointer;border-radius:0px;">
                        <div class="equipoContainer d-flex flex-row justify-content-center align-items-end"
                            style="background:#fff;border:1px solid #f4f4f4"
                            onclick="window.location='{{ route('page.productos', $item->id) }}'">
                            <div class="d-flex justify-content-start align-items-end col-6 pb-4">
                                <span class="px-5 text-center"><b>{{ $item->name }}</b></span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center col-6">
                                @if ($item->imagen)
                                    <img src="{{ asset(Storage::url($item->imagen)) }}" class="img-fluid px-4">
                                @else
                                    <img src="{{ asset('img/logo2.jpg') }}" class="px-4">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 px-2">
                    <span>No se encontraron productos.</span>
                </div>
            @endforelse
        </div>

    </div>
@endsection
@section('js')
    <script>
        $(document).on('keyup mouseup', '#btnColor', function() {
            let color = this.value;
            let productos = document.querySelectorAll('#boxProducto');

            productos.forEach(element => {
                if (element.classList.contains(color)) {
                    element.style.display = "block"
                } else {
                    element.style.display = "none"
                }
            })

        });
    </script>
@endsection
