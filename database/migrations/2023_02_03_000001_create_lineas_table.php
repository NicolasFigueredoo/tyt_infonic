<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineasTable extends Migration
{
    public function up()
    {
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

    public function down()
    {
        Schema::dropIfExists('lineas');
    }
}
