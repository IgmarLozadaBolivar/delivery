<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detalles_paquetes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paquete_id')->constrained('paquetes');
            $table->foreignId('tipo_mercancia_id')->constrained('tipos_mercancias');
            $table->string('dimension');
            $table->decimal('peso', 8, 2);
            $table->date('fecha_entrega');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_paquetes');
    }
};
