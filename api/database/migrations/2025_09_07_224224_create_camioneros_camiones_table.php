<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('camioneros_camiones', function (Blueprint $table) {
            $table->foreignId('camionero_id')->constrained('camioneros')->onDelete('cascade');
            $table->foreignId('camion_id')->constrained('camiones')->onDelete('cascade');

            $table->primary(['camionero_id', 'camion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('camioneros_camiones');
    }
};
