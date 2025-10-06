<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('camioneros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->unique();
            $table->string('documento', length: 10)->unique();
            $table->date('fecha_nacimiento');
            $table->enum('licencia', ['C2', 'C3']);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('camioneros');
    }
};
