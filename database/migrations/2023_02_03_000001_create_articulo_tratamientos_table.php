<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticuloTratamientosTable extends Migration
{
    public function up()
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tratamientos');
    }
}
