<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commodity_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('market_id')->unsigned();
            $table->string('name');
            $table->string('symbol');
            $table->integer('buy_price');
            $table->integer('sell_price');

            $table->foreign('market_id')->references('id')->on('markets')->onDelete('cascade');

            $table->timestampTz('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commodity_histories');
    }
};
