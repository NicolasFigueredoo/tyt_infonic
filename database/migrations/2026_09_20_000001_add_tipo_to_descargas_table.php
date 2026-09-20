<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTipoToDescargasTable extends Migration
{
    public function up()
    {
        Schema::table('descargas', function (Blueprint $table) {
            $table->string('tipo', 20)->default('lista')->after('tituloEnglish');
        });

        // Los registros existentes cuyo titulo menciona "catalogo" pasan a la nueva seccion.
        DB::table('descargas')
            ->where(function ($q) {
                $q->where('titulo', 'like', '%catalog%')
                    ->orWhere('titulo', 'like', '%catálog%')
                    ->orWhere('tituloEnglish', 'like', '%catalog%');
            })
            ->update(['tipo' => 'catalogo']);
    }

    public function down()
    {
        Schema::table('descargas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
