<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('predicted_prices', function (Blueprint $table) {
            $table->id('predicted_price_id');
            $table->foreignId('car_id')->constrained(
                table:'cars',
                column:'car_id',
            );
            $table->float('rf');
            $table->float('xgb');
            $table->float('lgbm');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predicted_prices');
    }
};
