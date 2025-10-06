<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('camiones', function (Blueprint $table) {
            $table->id();
            $table->string('marca', length: 50);
            $table->string('modelo', length: 50);
            $table->string('placa', length: 6)->unique();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('camiones');
    }
};
