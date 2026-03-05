<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FormularioClienteController extends Controller
{
    // POST /adm/formclientes/
    public function all(Request $request)
    {
        $query = DB::table('form_campos')->orderBy('orden')->orderBy('id');
        if ($request->filled('label')) {
            $query->where('label', 'like', '%' . $request->label . '%');
        }
        return response()->json($query->paginate($request->input('per_page', 20)));
    }

    // GET /adm/formclientes/{id}
    public function find($id)
    {
        $campo = DB::table('form_campos')->where('id', $id)->first();
        if (!$campo) return response()->json(['message' => 'No encontrado'], 404);

        // Para image_choice: opciones es array de {path, label}
        // Para otros tipos:  opciones es array de strings
        $campo->opciones = $campo->opciones ? json_decode($campo->opciones, true) : [];

        return response()->json($campo);
    }

    // POST /adm/formclientes/store/{id?}
    public function store(Request $request, $id = null)
    {
        $request->validate([
            'label'       => 'required|string|max:255',
            'tipo'        => 'required|in:text,email,number,textarea,select,checkbox,radio,file,link,image_choice',
            'placeholder' => 'nullable|string|max:255',
            'requerido'   => 'nullable|boolean',
            'orden'       => 'nullable|integer',
            'activo'      => 'nullable|boolean',
            'opciones'    => 'nullable|array',
            'opciones.*'  => 'string|max:255',
        ]);

        // Construir opciones según tipo
        $opciones = null;

        if (in_array($request->tipo, ['select', 'checkbox', 'radio'])) {
            $opciones = json_encode($request->input('opciones', []));
        }

        if ($request->tipo === 'image_choice') {
            $slots    = [];
            $labels   = $request->input('imagen_labels', []);
            $existing = $request->input('imagenes_existing', []);
            $archivos = $request->file('imagenes', []);

            // Determinar cuántos slots hay
            $count = max(count($labels), count($archivos), count($existing));

            for ($i = 0; $i < $count; $i++) {
                $path = $existing[$i] ?? null;

                // Si viene archivo nuevo para este slot, subirlo
                if (isset($archivos[$i]) && $archivos[$i]) {
                    // Borrar imagen vieja si existe
                    if ($path) Storage::disk('public')->delete($path);
                    $path = $archivos[$i]->store('form_imagenes', 'public');
                }

                if ($path) {
                    $slots[] = [
                        'path'  => $path,
                        'label' => $labels[$i] ?? '',
                    ];
                }
            }

            $opciones = json_encode($slots);
        }

        $data = [
            'label'       => $request->label,
            'tipo'        => $request->tipo,
            'placeholder' => $request->placeholder,
            'requerido'   => $request->boolean('requerido') ? 1 : 0,
            'orden'       => $request->input('orden', 0),
            'activo'      => $request->boolean('activo', true) ? 1 : 0,
            'tiene_otro'  => $request->boolean('tiene_otro') ? 1 : 0,
            'opciones'    => $opciones,
            'updated_at'  => now(),
            'campo_sistema' => $request->input('campo_sistema') ?: null,

        ];

        if ($id) {
            DB::table('form_campos')->where('id', $id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('form_campos')->insert($data);
        }

        return response()->json(['ok' => true]);
    }

    // GET /adm/formclientes/delete/{id}
    public function delete($id)
    {
        $campo = DB::table('form_campos')->where('id', $id)->first();
        if ($campo && $campo->tipo === 'image_choice' && $campo->opciones) {
            $slots = json_decode($campo->opciones, true);
            foreach ($slots as $slot) {
                if (!empty($slot['path'])) Storage::disk('public')->delete($slot['path']);
            }
        }
        DB::table('form_campos')->where('id', $id)->delete();
        return response()->json(['ok' => true]);
    }

    // POST /formclientes/submit  — usado desde el blade público
    public function submit(Request $request)
    {
        $campos = DB::table('form_campos')->where('activo', 1)->get();

        $rules = [];
        foreach ($campos as $campo) {
            if ($campo->requerido) $rules['campo_' . $campo->id] = 'required';
        }
        $request->validate($rules);

        $respuestaId = DB::table('form_respuestas')->insertGetId([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($campos as $campo) {
            $key   = 'campo_' . $campo->id;
            $valor = null;

            if ($campo->tipo === 'file') {
                if ($request->hasFile($key)) {
                    $valor = $request->file($key)->store('form_respuestas', 'public');
                }
            } elseif (in_array($campo->tipo, ['checkbox', 'image_choice'])) {
                $valor = $request->filled($key) ? json_encode($request->input($key)) : null;
            } else {
                $valor = $request->input($key);
                if ($valor === '__otro__') {
                    $valor = $request->input('campo_otro_' . $campo->id, 'Otro');
                }
            }

            DB::table('form_respuestas_detalle')->insert([
                'respuesta_id' => $respuestaId,
                'campo_id'     => $campo->id,
                'valor'        => $valor,
                'created_at'   => now(),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    // POST /adm/formclientes/respuestas
    public function respuestas(Request $request)
    {
        $respuestas = DB::table('form_respuestas')
            ->orderByDesc('id')
            ->paginate($request->input('per_page', 20));

        foreach ($respuestas as $respuesta) {
            $respuesta->detalle = DB::table('form_respuestas_detalle as d')
                ->join('form_campos as c', 'c.id', '=', 'd.campo_id')
                ->where('d.respuesta_id', $respuesta->id)
                ->select('c.label', 'c.tipo', 'd.valor')
                ->orderBy('c.orden')
                ->get();
        }

        return response()->json($respuestas);
    }
}