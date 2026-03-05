<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use App\Models\Producto;
use App\Models\FamiliaProducto;
use App\Models\Categoria;
use App\Models\PresentacionRelacion;

class YourImportClass implements ToArray
{
    public function array(array $array)
    {
        return $array;
    }
}