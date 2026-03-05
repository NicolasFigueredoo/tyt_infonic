<?php
namespace App\Libs;
// Clase lienzo
// ests clase permite añadir piezas.
// las piezas no pueden chocar entre si
// pueden colocarse en cualquier posicion, arriba, abajo, izquierda, derecha siempre que no choquen con otra pieza
// las piezas pueden ser de cualquier tamaño pero no pueden salirse del lienzo
// $lienzo = new Lienzo(10000, 4000, $lienzo['piezas']);
// $lienzo->addPieza(400, 300); // el algortimo debe buscar la posicion donde colocar la pieza, donde no choque con otra pieza
class Lienzo {
    private $tamanoX;
    private $tamanoY;
    private $piezas;
    public function __construct($tamanoX, $tamanoY, $piezas = []) {
        $this->tamanoX = $tamanoX;
        $this->tamanoY = $tamanoY;
        $this->piezas = $piezas;
    }
    public function addPieza($tamanoX, $tamanoY) {
        // recorro el eje y
        for ($y = 0; $y < $this->tamanoY; $y++) {
            // primero recorro el eje x
            for ($x = 0; $x < $this->tamanoX; $x++) {
                // compruebo si la pieza cabe en la posicion x, y
                if ($this->piezaCabe($x, $y, $tamanoX, $tamanoY)) {
                    // si cabe creo la pieza y la añado al array de piezas
                    $this->piezas[] = new Pieza($this->tamanoX, $this->tamanoY, $x, $y, $tamanoX, $tamanoY);
                    // devuelvo la pieza
                    return $this->piezas[count($this->piezas) - 1];
                }
            }
        }
    }
    private function piezaCabe($origenX, $origenY, $tamanoX, $tamanoY) {
        // compruebo que la pieza no se salga del lienzo
        if ($origenX + $tamanoX > $this->tamanoX) {
            return false;
        }
        if ($origenY + $tamanoY > $this->tamanoY) {
            return false;
        }
        // compruebo que la pieza no choque con otra pieza
        foreach ($this->piezas as $pieza) {
            if ($origenX + $tamanoX > $pieza->getOrigenX() && $origenX < $pieza->getOrigenX() + $pieza->getTamanoX()) {
                if ($origenY + $tamanoY > $pieza->getOrigenY() && $origenY < $pieza->getOrigenY() + $pieza->getTamanoY()) {
                    return false;
                }
            }
        }
        return true;
    }
    // esta funcion devuelve los metros cuadrados de todas las piezas
    public function getMetrosCuadrados() {
        $metrosCuadrados = 0;
        foreach ($this->piezas as $pieza) {
            $metrosCuadrados += $pieza->getTamanoX() * $pieza->getTamanoY();
        }
        return $metrosCuadrados;
    }
    public function getTamanoX() {
        return $this->tamanoX;
    }
    public function getTamanoY() {
        return $this->tamanoY;
    }
    public function getPiezas() {
        return $this->piezas;
    }
}
/*
$lienzo = new Lienzo(10000, 4000, $lienzo['piezas']);
$lienzo->addPieza(1000, 400);
print '<pre>';
print_r($lienzo->getPiezas());
print '</pre>';
?>
<!-- crear un html con el dibujo de las piezas -->
<div style="position: relative; width: 100%; height: 300px; border: 1px solid #000;">
    <?php foreach ($lienzo->getPiezas() as $pieza): ?>
        <div style="
            position: absolute;
            left: <?php print $pieza->getOrigenXPorcentaje(); ?>%;
            top: <?php print $pieza->getOrigenYPorcentaje(); ?>%;
            width: <?php print $pieza->getTamanoXPorcentaje(); ?>%;
            height: <?php print $pieza->getTamanoYPorcentaje(); ?>%;
            border: 1px solid #000;
        "></div>
    <?php endforeach; ?>
</div>
*/
/*
@foreach($rollos as $rollo)
    <h3>Rollo: {{ $rollo['rollo']->code }}</h3>
    <div style="position: relative; width: 100%; height: 100px; border: 1px solid #c9c9c9;box-sizing: border-box;">
    @foreach ($rollo['rollo']->entredas as $entrada)
        <div style="
            position: absolute;
            left: {{ $entrada->origen_x_porcentaje; }}%;
            top: {{ $entrada->origen_y_porcentaje; }}%;
            width: {{ $entrada->tamano_x_porcentaje; }}%;
            height: {{ $entrada->tamano_y_porcentaje; }}%;
            border: 1px solid #c9c9c9;
            box-sizing: border-box;
        "></div>
    @endforeach
    @foreach ($rollo['salidas'] as $salida)
        @php($salidas[] = $salida['salida'])
        <div style="
            position: absolute;
            left: {{ $salida['salida']->origen_x_porcentaje; }}%;
            top: {{ $salida['salida']->origen_y_porcentaje; }}%;
            width: {{ $salida['salida']->tamano_x_porcentaje; }}%;
            height: {{ $salida['salida']->tamano_y_porcentaje; }}%;
            border: 1px solid #565656;
            box-sizing: border-box;
            background: rgb(233,233,233);
            font-weight: normal;
            color: #565656;
        ">
            <span style="
                left: 50%;
                transform: translate(-50%, -50%);
                position: absolute;
                top: 50%;
                font-size: 10px;
                font-weight: bold;
            ">{{ count($salidas) }}</span>
        </div>
    @endforeach
</div>
@endforeach
<!-- Diagrama en svg -->
{{--
@foreach($rollos as $rollo)
    <svg style="height: 300px; width: 100%;" viewBox="0 0 {{ $rollo['rollo']->tamano_x }} {{ $rollo['rollo']->tamano_y }}" preserveAspectRatio="none">
        @foreach ($rollo['rollo']->entredas as $entrada)
            <rect x="{{ $entrada->origen_x; }}" y="{{ $entrada->origen_y; }}" width="{{ $entrada->tamano_x; }}" height="{{ $entrada->tamano_y; }}" fill="none" stroke="#c9c9c9" stroke-width="1"></rect>
        @endforeach
        @foreach ($rollo['salidas'] as $salida)
            <rect x="{{ $salida['salida']->origen_x; }}" y="{{ $salida['salida']->origen_y; }}" width="{{ $salida['salida']->tamano_x; }}" height="{{ $salida['salida']->tamano_y; }}" fill="rgb(233,233,233)" stroke="#565656" stroke-width="1"></rect>
        @endforeach
    </svg>
@endforeach
--}}

*/