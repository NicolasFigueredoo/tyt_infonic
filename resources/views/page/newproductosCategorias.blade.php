@extends('layouts.newplantilla')
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
    <style>
        .col-md-4-adjusted {
            width: calc(33.3333% - 16px); /* Ajusta el ancho restando 5px */
        }
        @media (max-width: 768px) {
            .col-md-4-adjusted {
                width: 95%;
            }
        }
    </style>
   <div class="d-flex justify-content-center">
        <div class="d-flex flex-row justify-content-center align-items-center align-items-md-start flex-wrap box_container py-5" style="gap: 10px">
            {{-- PRODUCTOS DESTACADOS --}}
            @forelse ($categorias as $item)
            @if($item->principal == 'true')
            
            <div id="boxProducto"
                    class="col-12 col-md-4 col-md-4-adjusted d-flex flex-column justify-content-end align-items-center align-items-md-start g-2 p-4 "
                    style="position: relative; text-transform: uppercase;
                    border-radius: 0px; background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover;
                    height: 360px; border-radius: 10px"
                    data-aos="zoom-in">
                <div>
                    <spam  style="color:#fff; font-weight: 600; font-size:16px; margin-bottom:0px"></spam>
                </div>

                    <div style="height: 24px; width:100%">
                        <div style="width:100%; height: 100%; background: url({{ $item->imagenMarca ? asset(Storage::url($item->imagenMarca)) : asset('img/logo2.jpg') }}) no-repeat; background-size: contain;">
    
                        </div>
    
                    </div>
                <div>
                    <p style="color:#fff; font-weight: 600; font-size:46px; margin-bottom:0px">{{ $item->name }}</p>
                </div>
                <div styl>
                    <a style="color:#fff; text-decoration:none" href="{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}">
                        @if(session('locale') === 'es')
                        Ver Categoría 
                        @else
                        View Category
                        @endif
                        <img src="{{ asset(Storage::url('tipo-articulo/arrow_forward.png')) }}"></a>
                </div>
                    <!-- <div class="d-flex flex-column justify-content-start align-items-center"
                        style="cursor:pointer;border-radius:0px;">
                        <div class="equipoContainer d-flex flex-row justify-content-center align-items-end"
                            style="background:#fff;border:1px solid #f4f4f4"
                            onclick="window.location='{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}'">
                            <div class="d-flex justify-content-start align-items-end col-6 pb-4">
                                <span class="px-5 text-center"><b>{{ $item->name }}</b></span>
                            </div>
                            
                        </div>
                    </div> -->
                </div>
                @endif
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
