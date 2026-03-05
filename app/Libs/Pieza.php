<?php
namespace App\Libs;
// app/Lib/Pieza.php
class Pieza {
    private $lienzoTamanoX = 0;
    private $lienzoTamanoY = 0;
    private $origenX = 0;
    private $origenY = 0;
    private $tamanoX = 0;
    private $tamanoY = 0;
    private $tipo_item = 'pieza';

    public function __construct($lienzoTamanoX, $lienzoTamanoY, $origenX, $origenY, $tamanoX, $tamanoY, $tipo_item = 'pieza') {
        $this->lienzoTamanoX = $lienzoTamanoX;
        $this->lienzoTamanoY = $lienzoTamanoY;
        $this->origenX = $origenX;
        $this->origenY = $origenY;
        $this->tamanoX = $tamanoX;
        $this->tamanoY = $tamanoY;
        $this->tipo_item = $tipo_item;
    }
    
    /**
     * Este metodo permite realiazar un corte en la pieza y generar las nuevas
     * piezas cuadradas.
     * @param int $tamanoX
     * @param int $tamanoY
     * @param string $posicionX puede ser 'izquierda' o 'derecha'
     * @param string $posicionY puede ser 'arriba' o 'abajo'
     */
    public function cortar($cTamanoX, $cTamanoY, $posicionX = 'derecha', $posicionY = 'abajo') {
        // inicializamos las variables de origen
        $piezas = [];
        $cOrigenX = 0;
        $cOrigenY = 0;
        if ($posicionX == 'izquierda') {
            // si posicionX es izquierda, el origenX es el mismo que la pieza
            $cOrigenX = $this->origenX;
        } else {
            // si posicionX es derecha, el origenX es el origenX de la pieza + el tamaño de la pieza - el tamaño del corte
            $cOrigenX = $this->origenX + $this->tamanoX - $cTamanoX;
        }
        if ($posicionY == 'arriba') {
            // si posicionY es arriba, el origenY es el mismo que la pieza
            $cOrigenY = $this->origenY;
        } else {
            // si posicionY es abajo, el origenY es el origenY de la pieza + el tamaño de la pieza - el tamaño del corte
            $cOrigenY = $this->origenY + $this->tamanoY - $cTamanoY;
        }
        $piezas[] = new Pieza($this->lienzoTamanoX, $this->lienzoTamanoY, $cOrigenX, $cOrigenY, $cTamanoX, $cTamanoY, 'pieza-corte');
        // creamos las piezas
        // si el alto del corte es menor que el alto de la pieza, creamos una nueva pieza arriba o abajo
        // dependiendo de la posicionY
        if ($cTamanoY < $this->tamanoY) {
            if ($posicionY == 'arriba') {
                $piezas[] = new Pieza($this->lienzoTamanoX, $this->lienzoTamanoY, $cOrigenX, $this->origenY + $cTamanoY, $cTamanoX, $this->tamanoY - $cTamanoY, 'pieza-nueva');
            } else {
                $piezas[] = new Pieza($this->lienzoTamanoX, $this->lienzoTamanoY, $cOrigenX, $this->origenY, $cTamanoX, $this->tamanoY - $cTamanoY, 'pieza-nueva');
            }
        }
        // si el ancho del corte es menor que el ancho de la pieza, creamos una nueva pieza izquierda o derecha
        // dependiendo de la posicionX
        if ($cTamanoX < $this->tamanoX) {
            if ($posicionX == 'izquierda') {
                $piezas[] = new Pieza($this->lienzoTamanoX, $this->lienzoTamanoY, $this->origenX + $cTamanoX, $this->origenY, $this->tamanoX - $cTamanoX, $this->tamanoY, 'pieza-nueva');
            } else {
                $piezas[] = new Pieza($this->lienzoTamanoX, $this->lienzoTamanoY, $this->origenX, $this->origenY, $this->tamanoX - $cTamanoX, $this->tamanoY, 'pieza-nueva');
            }
        }
        return $piezas;

    }

    public function getLienzoTamanoX() {
        return $this->lienzoTamanoX;
    }

    public function getLienzoTamanoY() {
        return $this->lienzoTamanoY;
    }
    public function getOrigenX() {
        return $this->origenX;
    }

    public function getOrigenY() {
        return $this->origenY;
    }

    public function getTamanoX() {
        return $this->tamanoX;
    }

    public function getTamanoY() {
        return $this->tamanoY;
    }

    public function getTamanoXPorcentaje() {
        return $this->tamanoX * 100 / $this->lienzoTamanoX;
    }

    public function getOrigenXPorcentaje() {
        return $this->origenX * 100 / $this->lienzoTamanoX;
    }

    public function getTamanoYPorcentaje() {
        return $this->tamanoY * 100 / $this->lienzoTamanoY;
    }

    public function getOrigenYPorcentaje() {
        return $this->origenY * 100 / $this->lienzoTamanoY;
    }

    public function getTipoItem() {
        return $this->tipo_item;
    }
}
/*
// un lienzo con 4 piezas
$lienzo = [
    'tamanoX' => 10000,
    'tamanoY' => 4000,
    'piezas' => [
        [
            'origenX' => 0,
            'origenY' => 0,
            'tamanoX' => 100,
            'tamanoY' => 4000,
        ],
        [
            'origenX' => 100,
            'origenY' => 0,
            'tamanoX' => 400,
            'tamanoY' => 3400,
        ],
        [
            'origenX' => 500,
            'origenY' => 0,
            'tamanoX' => 500,
            'tamanoY' => 2900,
        ],
        [
            'origenX' => 1000,
            'origenY' => 0,
            'tamanoX' => 900,
            'tamanoY' => 3500,
        ],
    ],
];
foreach ($lienzo['piezas'] as $key => $pieza) {
    $lienzo['piezas'][$key] = new Pieza($lienzo['tamanoX'], $lienzo['tamanoY'], $pieza['origenX'], $pieza['origenY'], $pieza['tamanoX'], $pieza['tamanoY']);
}
// prueba
$piezaOriginal = new Pieza(10000, 4000, 1900, 0, 1000, 3500);
$piezas = $piezaOriginal->cortar(500, 500, 'derecha', 'abajo');
$lienzo['piezas'] = array_merge($lienzo['piezas'], $piezas);
?>
<pre>
    <?php print_r($piezas); ?>
</pre>
<!-- crear un html con el dibujo de las piezas -->
<div style="position: relative; width: 100%; height: 300px; border: 1px solid #000;">
    <?php foreach ($lienzo['piezas'] as $pieza): ?>
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
<style>
    div {
        box-sizing: border-box;
    }
</style>

<?php
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