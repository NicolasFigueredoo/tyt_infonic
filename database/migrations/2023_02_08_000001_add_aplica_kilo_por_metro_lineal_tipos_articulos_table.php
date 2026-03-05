<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAplicaKiloPorMetroLinealTiposArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_articulos', function (Blueprint $table) {
            if ( ! Schema::hasColumn('tipos_articulos', 'aplica_kilo_por_metro_lineal')) {
                $table->integer('aplica_kilo_por_metro_lineal')->after('name')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_articulos', function (Blueprint $table) {
            if (Schema::hasColumn('tipos_articulos', 'aplica_kilo_por_metro_lineal')) {
                $table->dropColumn('aplica_kilo_por_metro_lineal');
            }
        });
    }
};
