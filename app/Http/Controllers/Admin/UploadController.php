<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls  as ReaderXls;
use PhpOffice\PhpSpreadsheet\Reader\Csv as ReaderCsv;
use PhpOffice\PhpSpreadsheet\Reader\Html as ReaderHtml;
use App\Models\Articulo;
use App\Models\Tratamiento;
use App\Models\Linea;
use App\Models\ArticuloStock;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\YourImportClass;

class UploadController extends Controller
{

    public function store(Request $request, $id = null)
    {
        // Realizo las validaciones
        $request->validate([
            /*
            El campo 'tipo_archivo' es requerido
            debe ser un string
            y no debe superar los 255 caracteres
            */
            'tipo_archivo' => 'required|string|max:255',
            /*
            El campo 'archivo' es requerido
            debe ser un archivo
            no debe superar los 10MB
            y debe ser de tipo xlsx
            */
            'archivo' => 'required|file|max:10240|mimes:xlsx'
        ]);

        $file = $request->file('archivo');
        try{

            $data = Excel::toArray(new YourImportClass, $file);
            $rows = $data[0]; // Obtener todas las filas

            $columns = array_shift($rows); // Extraer la primera fila (encabezados de columnas)
            
            foreach ($rows as $row) {
                $articulo = Articulo::where('code','=',$row[0])->first();
                if($articulo){
                    $articulo->cantidad = $row[8];
                    $articulo->save();
                }                
            }
        }catch(\Exception $e){
            return $e;
        }
    }
}
