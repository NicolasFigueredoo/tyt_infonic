@extends('layouts.newplantilla')
@section('content')

    <style>
        table thead {
            color: #000;
font-family: 'Inter', sans-serif;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: normal;
        }

        table tbody tr {
            color: #000;
font-family: 'Inter', sans-serif;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: normal;
        }

        .descargas {
            width: 1016px;
        }

        .descarga {
            background-color: #F4F4F4;
            margin-bottom: 24px;
            align-items: center;
            height: 217px;
            border-radius: 8px;
        }

        .descarga img {
            height: 152px;
            padding: 10px;
            width: 152px;
            margin-left: 62px;
            margin-right: 51px;
        }

        .descarga-nombre {
            font-family: Poppins;
            font-size: 32px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            margin-bottom: 17px;
        }

        #visualizar {
            /* color:#fff;
              background-color: var(--azuloscuro);
              border-color: var(--azuloscuro); */
            width: 100%
        }

        #visualizar:hover {
            color: #000;
            background-color: transparent;
        }

        .green-btn {
            padding: 12px 42px 12px 42px;
        }

        .descarga-btns {
            padding-right: 60px;
            align-content: center;
        }

        .dropdown-menu {
            border-radius: 0px 0px 15px 15px;
            background: #FFF;
            box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.35);
            padding: 0;
        }

        .dropdown-menu li {
            width: 245px;
            border-bottom: 1px solid #D8D8D8;
            padding: 0;
        }

        .dropdown-item:hover {
            background-color: rgba(78, 153, 212, 0.22);
        }

        .dow-btn {
            width: 182px;
height: 41px;
flex-shrink: 0;
color: #fff !important;
    background: #F15E40 !important; 
    border-radius: 35px !important;
text-align: center;
font-family: 'Inter', sans-serif;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: normal;
border: 1px solid #FF8B00;


        }

        .dow-btn:hover {
            background: transparent !important;
            border: 1px solid #F15E40;
            color: #F15E40 !important;
        }

        .ver-btn {
            width: 182px;
height: 41px;
flex-shrink: 0;
background: var(--Naranja, #FF8B00);
color: #FFF;
text-align: center;
font-family: 'Inter', sans-serif;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: normal;
border: 1px solid #fff;
border-radius: 35px !important;
border: 1px solid #F15E40 !important;

        }

        .ver-btn:hover {
            background: #F15E40;
            border: 1px solid #F15E40;
            color: #fff !important;
        }

        @media (max-width: 990px) {
            .descargas {
                width: auto;

                max-width: 100%;
            }

            .descarga {
                margin-left: 20px;
                margin-right: 20px;
                height: auto;
            }

            .descarga-nombre {
                font-size: 20px;
                padding-top: 20px;
                margin-bottom: 12px;
            }

            .descarga-btns {
                padding: 20px 30px 10px 30px;
            }

            .descarga img {
                height: 100px;
                padding: 10px;
                width: 100px;
                margin: 0;
            }

            .descarga-nombre {
                width: auto;
            }

            .green-btn:not(.zona-cliente-btn) {
                padding-left: 0;
                padding-right: 0;
            }
        }
    </style>


@section('content')



    <section style="padding-top: 60px; padding-bottom: 597px">

        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="contenido">
                            <th scope="col"></th>
                            <th scope="col" style="text-align: start"> 
                                Nombre
                          

                            </th>
                            <th scope="col" style="text-align: start"> 
                                Link
                          

                            </th>
                            {{-- <th scope="col" style="text-align: start">        
                                Formato     
                             </th>
                            <th scope="col" style="text-align: start">        
                                Peso    
                            </th> --}}

                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($descargas as $lista)
                            <tr style="height: 109px !important">
                                <th style="min-width: 150px;">
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="width: 80px; height: 80px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                        viewBox="0 0 30 30" fill="none">
                                        <path
                                            d="M17.5 2.5V7.5C17.5 8.16304 17.7634 8.79893 18.2322 9.26777C18.7011 9.73661 19.337 10 20 10H25M12.5 11.25H10M20 16.25H10M20 21.25H10M18.75 2.5H7.5C6.83696 2.5 6.20107 2.76339 5.73223 3.23223C5.26339 3.70107 5 4.33696 5 5V25C5 25.663 5.26339 26.2989 5.73223 26.7678C6.20107 27.2366 6.83696 27.5 7.5 27.5H22.5C23.163 27.5 23.7989 27.2366 24.2678 26.7678C24.7366 26.2989 25 25.663 25 25V8.75L18.75 2.5Z"
                                            stroke="#F15E40" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                        {{-- @if ($lista->formato == 'pdf')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                viewBox="0 0 30 30" fill="none">
                                                <path
                                                    d="M17.5 2.5V7.5C17.5 8.16304 17.7634 8.79893 18.2322 9.26777C18.7011 9.73661 19.337 10 20 10H25M12.5 11.25H10M20 16.25H10M20 21.25H10M18.75 2.5H7.5C6.83696 2.5 6.20107 2.76339 5.73223 3.23223C5.26339 3.70107 5 4.33696 5 5V25C5 25.663 5.26339 26.2989 5.73223 26.7678C6.20107 27.2366 6.83696 27.5 7.5 27.5H22.5C23.163 27.5 23.7989 27.2366 24.2678 26.7678C24.7366 26.2989 25 25.663 25 25V8.75L18.75 2.5Z"
                                                    stroke="#FF8B00" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="51" height="57" viewBox="0 0 51 57" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.59337 1.49376C7.54981 0.537322 8.84702 0 10.1996 0H45.8998C47.2524 0 48.5496 0.53732 49.5061 1.49376C50.4625 2.4502 50.9998 3.74742 50.9998 5.10002V51.0002C50.9998 52.3528 50.4625 53.65 49.5061 54.6065C48.5496 55.5629 47.2524 56.1002 45.8998 56.1002H10.1996C8.84703 56.1002 7.54981 55.5629 6.59337 54.6065C5.63693 53.65 5.09961 52.3528 5.09961 51.0002V42.0751H2.55001C1.14168 42.0751 0 40.9334 0 39.5251V16.575C0 15.1667 1.14168 14.025 2.55001 14.025H5.09961V5.10002C5.09961 3.74741 5.63693 2.4502 6.59337 1.49376ZM7.63179 19.125C7.63773 19.1251 7.64367 19.1251 7.64962 19.1251C7.65557 19.1251 7.66151 19.1251 7.66745 19.125H22.9501V36.9751H5.10002V19.125H7.63179ZM10.1996 14.025L10.1996 5.10002H45.8998V51.0002H10.1996V42.0751H25.5001C26.9084 42.0751 28.0501 40.9334 28.0501 39.5251V16.575C28.0501 15.1667 26.9084 14.025 25.5001 14.025H10.1996ZM34.4246 16.5749C34.4246 15.1666 35.5663 14.0249 36.9746 14.0249H40.7997C42.208 14.0249 43.3497 15.1666 43.3497 16.5749C43.3497 17.9832 42.208 19.1249 40.7997 19.1249H36.9746C35.5663 19.1249 34.4246 17.9832 34.4246 16.5749ZM30.5996 26.775C30.5996 25.3666 31.7413 24.2249 33.1496 24.2249H40.7997C42.208 24.2249 43.3497 25.3666 43.3497 26.775C43.3497 28.1833 42.208 29.325 40.7997 29.325H33.1496C31.7413 29.325 30.5996 28.1833 30.5996 26.775ZM30.5996 36.975C30.5996 35.5667 31.7413 34.425 33.1496 34.425H40.7997C42.208 34.425 43.3497 35.5667 43.3497 36.975C43.3497 38.3833 42.208 39.525 40.7997 39.525H33.1496C31.7413 39.525 30.5996 38.3833 30.5996 36.975ZM12.0032 22.4219C11.0073 21.4261 9.39275 21.4261 8.39691 22.4219C7.40107 23.4178 7.40107 25.0323 8.39691 26.0282L10.4188 28.0501L8.39691 30.0719C7.40107 31.0678 7.40107 32.6824 8.39691 33.6782C9.39275 34.674 11.0073 34.674 12.0032 33.6782L14.0251 31.6563L16.0469 33.6782C17.0428 34.674 18.6574 34.674 19.6532 33.6782C20.649 32.6824 20.649 31.0678 19.6532 30.0719L17.6313 28.0501L19.6532 26.0282C20.649 25.0323 20.649 23.4178 19.6532 22.4219C18.6574 21.4261 17.0428 21.4261 16.0469 22.4219L14.0251 24.4438L12.0032 22.4219Z" fill="#FF8B00"/>
                                          </svg>
                                        @endif --}}
                                    </div>

                                </th>
                                <td style="min-width: 400px; padding-top: 40px">{{ ucfirst($lista->titulo) }}</td>
                                <td style="padding-top: 40px"><a target="_blank" href="{{$lista->link}}">{{$lista->link}}</a></td>
                                {{-- <td style="min-width: 150px; text-transform: uppercase; padding-top: 40px">{{ $lista->formato }}</td>
                                <td style="min-width: 150px; padding-top: 40px">{{ $lista->peso }}</td> --}}
                                <td style="padding-top: 30px"> <a href="{{ asset(Storage::url($lista->imagen)) }}"
                                    download="{{ $lista->imagen }}"><button class="btn ver-btn">
                                        Descargar     
                                     
                                        </button> </a>
                            </td>
                                <td style="padding-top: 30px"><button onclick="visualizar_pdf(event)" data-pdf='{{ asset(Storage::url($lista->imagen)) }}'
                                        class="btn dow-btn">

                                        
                                        Visualizar
                                       
                                    </button></td>
                            
                            </tr>
                        @endforeach


                    </tbody>
                </table>

            </div>

        </div>
    </section>
@endsection

@section('js')
    <script>
        function visualizar_pdf(event) {
            var pdfURL = event.target.getAttribute(
                'data-pdf') // Reemplaza 'ruta/al/archivo.pdf' con la URL de tu archivo PDF
            window.open(pdfURL, '_blank');
        }
    </script>
@endsection