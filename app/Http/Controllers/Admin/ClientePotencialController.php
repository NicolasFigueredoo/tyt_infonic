<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClienteRegistro;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClientePotencialController extends Controller
{
    private $model = ClienteRegistro::class;
    private $name  = 'Cliente';

    public function all()
    {
        $data = $this->model::withTrashed()->orderBy('id', 'desc');

        if (request()->has('filters') && is_array(request()->filters)) {
            foreach (request()->filters as $key => $value) {
                $data->where($key, 'like', '%' . $value . '%');
            }
        }

        return $data->paginate();
    }

    public function find($id)
    {
        $item = $this->model::withTrashed()->find($id);
        if (!$item) {
            return response()->json(['message' => $this->name . ' not found'], 404);
        }

        // Cargar todos los campos activos del formulario
        $campos = DB::table('form_campos')
            ->where('activo', 1)
            ->orderBy('orden')
            ->get();

        // Buscar la respuesta del cliente
        $respuesta = DB::table('form_respuestas')
            ->where('cliente_registro_id', $id)
            ->orderByDesc('id')
            ->first();

        // Mapear respuestas por campo_id
        $detalles = [];
        if ($respuesta) {
            $rows = DB::table('form_respuestas_detalle')
                ->where('respuesta_id', $respuesta->id)
                ->get();
            foreach ($rows as $row) {
                $detalles[$row->campo_id] = $row->valor;
            }
        }

        // Construir array de campos con su valor respondido
        $item->campos_form = $campos->map(function ($campo) use ($detalles, $item) {
            $valor = null;

            // Si el campo está vinculado a una columna del modelo, leer de ahí
            if ($campo->campo_sistema && isset($item->{$campo->campo_sistema})) {
                $valor = $item->{$campo->campo_sistema};
            }
            // Si además hay respuesta guardada en form_respuestas_detalle, tiene prioridad
            if (isset($detalles[$campo->id])) {
                $valor = $detalles[$campo->id];
            }

            $opciones = $campo->opciones ? json_decode($campo->opciones, true) : [];

            return [
                'id'            => $campo->id,
                'label'         => $campo->label,
                'tipo'          => $campo->tipo,
                'campo_sistema' => $campo->campo_sistema,
                'opciones'      => $opciones,
                'valor'         => $valor,
                'valor_array'   => in_array($campo->tipo, ['checkbox', 'image_choice'])
                                    ? json_decode($valor, true) ?? []
                                    : null,
            ];
        });

        return $item;
    }

    public function store(Request $request, $id = null)
    {
        $item = $this->model::withTrashed()->find($id);
        if (!$item) return response()->json(['message' => 'Not found'], 404);

        $item->email = $request->email;
        $item->save();

        return $item;
    }

    public function delete($id)
    {
        $item = $this->model::find($id);
        $item->delete();
        return $item;
    }
}