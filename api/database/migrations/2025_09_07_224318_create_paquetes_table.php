<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('camionero_id')->constrained('camioneros');
            $table->foreignId('estado_id')->constrained('estados_paquetes');
            $table->string('direccion');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paquetes');
    }
};
