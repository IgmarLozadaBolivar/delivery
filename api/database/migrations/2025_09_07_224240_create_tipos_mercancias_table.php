<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tipos_mercancias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', length: 45);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_mercancias');
    }
};
