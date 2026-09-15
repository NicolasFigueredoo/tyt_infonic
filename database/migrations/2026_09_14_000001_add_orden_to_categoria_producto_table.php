<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrdenToCategoriaProductoTable extends Migration
{
    public function up()
    {
        Schema::table('categoria_producto', function (Blueprint $table) {
            $table->unsignedInteger('orden')->nullable()->after('tipo_articulo_id');
        });
    }

    public function down()
    {
        Schema::table('categoria_producto', function (Blueprint $table) {
            $table->dropColumn('orden');
        });
    }
}
