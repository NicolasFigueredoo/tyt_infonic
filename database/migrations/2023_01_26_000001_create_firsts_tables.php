<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstsTables  extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacenes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        app('db')->table('almacenes')->insert([
            ['id' => 1, 'code' => 'P', 'name' => 'Principal', 'description' => 'Almacen principal']
        ]);

        Schema::create('proveedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('business_name')->nullable();
            $table->string('cuit')->nullable();
            $table->unsignedBigInteger('provincia_id')->nullable();
            $table->string('provincia')->nullable();
            $table->unsignedBigInteger('localidad_id')->nullable();
            $table->string('localidad')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tipos_articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->integer('aplica_kilo_por_metro_lineal')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
        app('db')->table('tipos_articulos')->insert([
            ['id' => 1, 'name' => 'Perfiles',   'aplica_kilo_por_metro_lineal' => 1],
            ['id' => 2, 'name' => 'Herrajes',   'aplica_kilo_por_metro_lineal' => 0],
            ['id' => 3, 'name' => 'Accesorios', 'aplica_kilo_por_metro_lineal' => 0],
            ['id' => 4, 'name' => 'Vidrios',    'aplica_kilo_por_metro_lineal' => 0],
            ['id' => 5, 'name' => 'Otros',      'aplica_kilo_por_metro_lineal' => 0],
        ]);

        Schema::create('articulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->decimal('stock-min',  10, 2)->default(0)->nullable();
            $table->decimal('stock-max',  10, 2)->default(0)->nullable();
            $table->decimal('stock-disponible',  10, 2)->default(0)->nullable();
            $table->decimal('stock-bloqueado',  10, 2)->default(0)->nullable();
            $table->decimal('stock-total',  10, 2)->default(0)->nullable();
            $table->bigInteger('tipo_articulo_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        /*
        app('db')->table('articulos')->insert([
            [
                'code' => 'H-H136',
                'name' => 'Cierre Multipunto Kit hojas 45º A40RPT',
                'tipo_articulo_id' => 1
            ],
            [
                'code' => 'H-MKEYCHAM3',
                'name' => 'Cierre Multipunto Kit hojas 45º A40RPT con cerradura',
                'tipo_articulo_id' => 1
            ],
            [
                'code' => 'H-H136',
                'name' => 'ANTIFALSA MANIOBRA',
                'tipo_articulo_id' => 1
            ],
            [
                'code' => 'H-KCHAMP',
                'name' => 'KIT CHAMPION A40 RPT',
                'tipo_articulo_id' => 1
            ]
        ]);
        */
        Schema::create('articulo_stock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('articulo_id')->nullable();
            $table->bigInteger('almacen_id')->nullable();
            $table->string('ubicacion')->nullable();
            $table->decimal('cantidad',  10, 2)->default(0)->nullable();
            $table->decimal('peso',  10, 2)->default(0)->nullable();
            $table->string('observaciones')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('articulo_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('articulo_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('message')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'almacenes',
            'proveedores',
            'clientes',
            'tipos_articulos',
            'articulos',
            'articulo_stock',
            'articulo_logs'
        ];
        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }
    }
};
