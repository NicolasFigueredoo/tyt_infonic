<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulos', function (Blueprint $table) {
            if (!Schema::hasColumn('articulos', 'kilos_por_metro')) {
                $table->decimal('kilos_por_metro',  10, 2)->after('stock-total')->default(0)->nullable();
            }
        });
        Schema::table('articulo_stock', function (Blueprint $table) {
            if (!Schema::hasColumn('articulo_stock', 'tratamiento_id')) {
                $table->bigInteger('tratamiento_id')->after('observaciones')->nullable();
            }
        });
        if (!Schema::hasTable('lineas')) {
            Schema::create('lineas', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articulos', function (Blueprint $table) {
            if (Schema::hasColumn('articulos', 'kilos_por_metro')) {
                $table->dropColumn('kilos_por_metro');
            }
        });
        Schema::table('articulo_stock', function (Blueprint $table) {
            if (Schema::hasColumn('articulo_stock', 'tratamiento_id')) {
                $table->dropColumn('tratamiento_id');
            }
        });
        Schema::dropIfExists('lineas');
    }
};