<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\PedidoItemHistorial;
use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller {
    private $model = Pedido::class;
    private $name = 'Pedido';
    private $prefixPermission = 'provincia';

    public function all() {
        // sniff($this->prefixPermission . '-*');
        $data = $this->model::orderBy('id', 'desc');
        
        return $data->paginate();
    }

    public function find($id) {
        $item = $this->model::find($id);
        if ($item) {            
            return $item;
        }
        return response()->json(['message' => $this->name . ' not found'], 404);
    }

    public function store(Request $request, $id = null) {
        // validate the request
        $request->validate([
            'cliente_id' => 'required',
            'codigo' => 'required',
        ]);
        // store a new item
        if ($id && ! $request->has('__form-input-copy') ) {
            $item = $this->model::find($id);
        } else {
            $item = new $this->model;
        }
        $item->cliente_id    = $request->cliente_id;
        $item->codigo        = $request->codigo;
        $item->fecha_pedido  = $request->fecha_pedido;
        $item->operario_id   = auth()->user()->id;
        $item->fecha_entrega = $request->fecha_entrega;
        $item->prioridad     = $request->prioridad;
        $item->save();
        if ( request()->has('items') ) {
            foreach (request()->items as $key => $ii) {
                for ($i=1; $i <= $ii['cantidad']; $i++) { 
                    PedidoItem::create([
                        'codigo' => $request->codigo . '/' . ($key + 1)  . '/' . $i . '-' . $ii['cantidad'],
                        'articulo_id'       => $ii['articulo_id'],
                        'articulo_union_id' => $ii['articulo_union_id'],
                        'ancho'             => $ii['ancho'],
                        'largo'             => $ii['largo'],
                        'prioridad'         => $ii['prioridad'],
                        'estado'            => 'sin-asignar',
                        'pedido_id'         => $item->id            
                    ]);
                }
            }
        }
        return $item;
    }

    public function delete($id) {
        $item = $this->model::find($id);
        $item->delete();
        return $item;
    }

    public function restore($id) {
        $item = $this->model::withTrashed()->find($id);
        $item->restore();
        return $item;
    }

    public function destroy($id) {
        $item = $this->model::withTrashed()->find($id);
        $item->forceDelete();
        return $item;
    }

    public function deleteItem($id) {
        $item = PedidoItem::find($id);
        PedidoItemHistorial::create([
            'mensaje'        => auth()->user()->name . ' eliminó el item, Motivo: ' . request()->comentario,
            // 'level'          =>,
            'pedido_item_id' => $id,
            'user_id'        => auth()->user()->id
        ]);
        $item->delete();
        return $item;
    }

    public function imprimirOrdenTrabajo($pedido_id) {
        $pedido = Pedido::with([
            'items' => function($query) {
                $query->orderBy('prioridad', 'DESC');
            },
            'items.articulo',
            'items.salida',
            'items.historial',
            'cliente',
        ])->find($pedido_id);
        $rollos = [];
        foreach ($pedido->items as $key => $item) {
            if ( $item->salida && ( $item->salida->estado == 'corte-sin-confirmar' ) ) {
                // rollo
                $rollos[$item->salida->rollo->id]['rollo'] = $item->salida->rollo;
                if ( !array_key_exists('salidas', $rollos[$item->salida->rollo->id] ) )
                    $rollos[$item->salida->rollo->id]['salidas'] = [];


                $rollos[$item->salida->rollo->id]['salidas'][$item->salida->id]['salida'] = $item->salida;
                if ( !array_key_exists('items', $rollos[$item->salida->rollo->id]['salidas'][$item->salida->id] ) )
                    $rollos[$item->salida->rollo->id]['salidas'][$item->salida->id]['items'] = [];

                $rollos[$item->salida->rollo->id]['salidas'][$item->salida->id]['items'][] = $item;
            }
        }
        // return view('pedido.orden-trabajo', [ 'pedido' => $pedido, 'rollos' => $rollos ]);
        $pdf = Pdf::loadView('pedido.orden-trabajo', [
            'pedido' => $pedido,
            'rollos' => $rollos
        ]);
        return $pdf->stream('orden-trabajo.pdf');
    }
}