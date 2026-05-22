<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background: #ffffff;">

    {{-- Header --}}
    <div style="background: #F15E40; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
        <h1 style="color: #fff; margin: 0; font-size: 22px;">Nuevo cliente registrado</h1>
    </div>

    {{-- Mensaje para el cliente --}}
    <div style="border: 1px solid #e5e7eb; border-top: none; padding: 24px 20px; background: #ffffff;">

        <p style="font-size: 15px; color: #111827; margin: 0 0 14px 0;">
            Gracias por registrarte como cliente de TyT. En los próximos cinco días hábiles, nuestro departamento de ventas
            se estará contactando con vos telefónicamente.
        </p>

        <p style="font-size: 15px; color: #111827; margin: 0 0 14px 0;">
            Ante cualquier consulta, podés comunicarte con nosotros a nuestro correo
            <a href="mailto:Info@tytsa.com.ar" style="color: #F15E40; text-decoration: none;">Info@tytsa.com.ar</a>.
        </p>

        <p style="font-size: 15px; color: #111827; margin: 0 0 14px 0;">
            Si querés ir conociendo todas nuestras líneas de accesorios para autos y de detailing,
            <a href="https://www.tytsa.com.ar/catalogo" style="color: #F15E40; text-decoration: none;">clickeá acá</a>.
        </p>

        <p style="font-size: 15px; color: #111827; margin: 0 0 8px 0;">
            También podés seguirnos en nuestras redes:
        </p>

        <p style="margin: 0 0 4px 0;">
            <a href="https://www.instagram.com/tytsa.com.ar/" style="color: #F15E40; text-decoration: none; font-size: 14px;">
                📷 @tytsa.com.ar
            </a>
        </p>
        <p style="margin: 0 0 4px 0;">
            <a href="https://www.instagram.com/laffitte.detail/" style="color: #F15E40; text-decoration: none; font-size: 14px;">
                📷 @laffitte.detail
            </a>
        </p>
        <p style="margin: 0 0 0 0;">
            <a href="https://www.instagram.com/qklperformance.ok/" style="color: #F15E40; text-decoration: none; font-size: 14px;">
                📷 @qklperformance.ok
            </a>
        </p>

    </div>

    {{-- Separador --}}
    <div style="border-top: 2px solid #F15E40; margin: 24px 0;"></div>

    {{-- Título datos del formulario --}}
    <p style="font-size: 13px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: .05em; margin: 0 0 12px 0;">
        Datos completados en el formulario
    </p>

    {{-- Tabla de datos --}}
    <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">

        @foreach($camposForm as $campo)

            @php
                $valor = null;

                if ($campo['tipo'] === 'image_choice') {
                    $valor = implode(', ', $campo['valor_array'] ?? []);
                } elseif ($campo['tipo'] === 'checkbox') {
                    $valor = implode(', ', $campo['valor_array'] ?? []);
                } elseif ($campo['tipo'] === 'file') {
                    $valor = $campo['valor'] ? asset('storage/' . $campo['valor']) : null;
                } else {
                    $valor = $campo['valor'];
                }
            @endphp

            @if($valor)
                <div style="display: flex; border-bottom: 1px solid #f3f4f6;">
                    <div style="width: 40%; padding: 12px 16px; background: #f9fafb; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: .05em;">
                        {{ $campo['label'] }}
                    </div>
                    <div style="width: 60%; padding: 12px 16px; font-size: 15px; color: #111827; font-weight: 500;">
                        @if($campo['tipo'] === 'file')
                            <a href="{{ $valor }}" style="color: #F15E40;">Ver archivo</a>
                        @else
                            {{ $valor }}
                        @endif
                    </div>
                </div>
            @endif

        @endforeach

    </div>

    {{-- Footer --}}
    <p style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;">
        TyT SA — Administración de clientes
    </p>

</div>