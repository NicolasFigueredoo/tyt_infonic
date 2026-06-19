<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background: #ffffff;">

    {{-- Header --}}
    <div style="background: #F15E40; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
        <h1 style="color: #fff; margin: 0; font-size: 22px;">Nueva postulación recibida</h1>
    </div>

    {{-- Cuerpo --}}
    <div style="border: 1px solid #e5e7eb; border-top: none; padding: 24px 20px; background: #ffffff;">
        <p style="font-size: 15px; color: #111827; margin: 0 0 14px 0;">
            Se recibió una nueva postulación a través del sitio web.
            @if(isset($oferta_id) && $oferta_id)
                Posición: <strong>Oferta #{{ $oferta_id }}</strong>.
            @else
                El candidato se postuló a la <strong>base general</strong>.
            @endif
        </p>
    </div>

    {{-- Separador --}}
    <div style="border-top: 2px solid #F15E40; margin: 24px 0;"></div>

    {{-- Datos del candidato --}}
    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: .05em; margin: 0 0 12px 0;">
        Datos del candidato
    </p>

    <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">

        @foreach([
            'Nombre'    => ($nombre ?? '') . ' ' . ($apellido ?? ''),
            'Dirección' => $direccion ?? '',
            'Teléfono'  => $telefono ?? '',
            'Email'     => $email ?? '',
        ] as $label => $valor)
            @if($valor)
            <div style="display: flex; border-bottom: 1px solid #f3f4f6;">
                <div style="width: 40%; padding: 12px 16px; background: #f9fafb; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: .05em;">
                    {{ $label }}
                </div>
                <div style="width: 60%; padding: 12px 16px; font-size: 15px; color: #111827; font-weight: 500;">
                    {{ $valor }}
                </div>
            </div>
            @endif
        @endforeach

    </div>

    <p style="font-size: 14px; color: #555; margin-top: 16px;">
        El CV del candidato se encuentra adjunto en este correo.
    </p>

    {{-- Footer --}}
    <p style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;">
        TyT SA — Recursos Humanos
    </p>

</div>