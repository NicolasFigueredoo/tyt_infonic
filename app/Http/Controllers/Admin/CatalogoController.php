<?php

namespace App\Http\Controllers\Admin;

/**
 * Seccion "Catalogos" del admin: mismo CRUD que Lista de precios (modelo Descarga),
 * acotado a los registros con tipo = 'catalogo'.
 */
class CatalogoController extends DescargaController {

    protected $name = 'Catálogos';
    protected $tipo = 'catalogo';

}
