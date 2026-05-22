@extends('layouts.newplantilla')

@section('content')

    <div class="d-flex justify-content-center" style="min-height: 40vh;">
        <div class="box_container py-5 px-4" style="max-width: 700px;">

            @if (session('locale') === 'es')

                <h5 style="color:#F15E40; font-weight:bold; margin-bottom: 20px;">
                    ¡Gracias por registrarte!
                </h5>

                <p>
                    Gracias por registrarte como cliente de TyT. Recibirás un mail de confirmación a la dirección de correo
                    brindada. En los próximos cinco días hábiles, nuestro departamento de ventas se estará contactando con vos
                    telefónicamente.
                </p>

                <p>
                    Ante cualquier consulta, podés comunicarte con nosotros a
                    <a href="mailto:Info@tytsa.com.ar" style="color:#F15E40;">Info@tytsa.com.ar</a>.
                    {{-- ← Reemplazar con el correo que confirmen --}}
                </p>

                <p>
                    Si querés ir conociendo todas nuestras líneas de accesorios para autos y de detailing,
                    <a href="https://www.tytsa.com.ar/catalogo" target="_blank" style="color:#F15E40;">clickeá acá</a>.
                </p>

                <p class="mb-2">También podés seguirnos en nuestras redes:</p>

                <div class="d-flex flex-column gap-1" style="gap: 6px;">
                    <a href="https://www.instagram.com/tytsa.com.ar/" target="_blank" style="color:#F15E40; text-decoration:none;">
                        <i class="fab fa-instagram me-1"></i> @tytsa.com.ar
                    </a>
                    <a href="https://www.instagram.com/laffitte.detail/" target="_blank" style="color:#F15E40; text-decoration:none;">
                        <i class="fab fa-instagram me-1"></i> @laffitte.detail
                    </a>
                    <a href="https://www.instagram.com/qklperformance.ok/" target="_blank" style="color:#F15E40; text-decoration:none;">
                        <i class="fab fa-instagram me-1"></i> @qklperformance.ok
                    </a>
                </div>

            @else

                <h5 style="color:#F15E40; font-weight:bold; margin-bottom: 20px;">
                    Thank you for registering!
                </h5>

                <p>
                    Thank you for registering as a TyT customer. You will receive a confirmation email at the address provided.
                    Within the next five business days, our sales department will be in touch with you by phone.
                </p>

                <p>
                    For any inquiries, feel free to contact us at
                    <a href="mailto:Info@tytsa.com.ar" style="color:#F15E40;">Info@tytsa.com.ar</a>.
                </p>

                <p>
                    To explore our full range of car accessories and detailing products,
                    <a href="https://www.tytsa.com.ar/catalogo" target="_blank" style="color:#F15E40;">click here</a>.
                </p>

                <p class="mb-2">You can also follow us on social media:</p>

                <div class="d-flex flex-column" style="gap: 6px;">
                    <a href="https://www.instagram.com/tytsa.com.ar/" target="_blank" style="color:#F15E40; text-decoration:none;">
                        <i class="fab fa-instagram me-1"></i> @tytsa.com.ar
                    </a>
                    <a href="https://www.instagram.com/laffitte.detail/" target="_blank" style="color:#F15E40; text-decoration:none;">
                        <i class="fab fa-instagram me-1"></i> @laffitte.detail
                    </a>
                    <a href="https://www.instagram.com/qklperformance.ok/" target="_blank" style="color:#F15E40; text-decoration:none;">
                        <i class="fab fa-instagram me-1"></i> @qklperformance.ok
                    </a>
                </div>

            @endif

        </div>
    </div>

@endsection