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
        Schema::table('articulo_stock', function (Blueprint $table) {
            if (!Schema::hasColumn('articulo_stock', 'medida')) {
                $table->string('code')->after('id')->nullable();
                $table->decimal('medida',  10, 2)->after('tratamiento_id')->default(0)->nullable();
                $table->string('medida_unidad')->after('medida')->nullable();
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
        $columns = ['code', 'medida', 'medida_unidad'];
        Schema::table('articulo_stock', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                if (Schema::hasColumn('articulo_stock', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};