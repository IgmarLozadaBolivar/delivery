<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('estados_paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('estado', length: 45);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estados_paquetes');
    }
};
