<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->string('manufacturer');
            $table->string('cylinders');
            $table->string('fuel');
            $table->integer('odometer');
            $table->string('transmission');
            $table->string('drive');
            $table->string('type');
            $table->string('paint_color');
            $table->string('state');
            $table->integer('age');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
