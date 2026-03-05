<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background: #ffffff;">

    <div style="background: #F15E40; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
        <h1 style="color: #fff; margin: 0; font-size: 22px;">Nuevo cliente registrado</h1>
    </div>

    <div style="border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px; overflow: hidden;">

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
                <div style="width: 40%; padding: 12px 16px; background: #f9fafb; font-size: 12px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: .05em; vertical-align: top;">
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

    <p style="text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px;">
        TyT SA — Administración de clientes
    </p>

</div>