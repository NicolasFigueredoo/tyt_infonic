<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedido Pendiente</title>
</head>
<body>
    <h1>Hola, {{ $cliente->nombre }}</h1>
    <p>
        Hemos notado que dejaste artículos en tu carrito de compras y aún no completaste tu pedido.
    </p>
    <p>
        Han pasado {{ $lapso }} horas desde tu última actividad. Te recordamos que tu pedido sigue pendiente.
    </p>
    <p>
        Haz clic en el siguiente enlace para finalizar tu compra:
    </p>
    <p>
        <a href="{{ route('page.carrito') }}">Completar mi pedido</a>
    </p>
    <p>
        ¡No dejes pasar esta oportunidad!
    </p>
    <p>
        Saludos,<br>
        El equipo de TYT
    </p>
</body>
</html>
