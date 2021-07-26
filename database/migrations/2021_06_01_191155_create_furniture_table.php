<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFurnitureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('furniture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('furniture_type_id')->constrained()->onDelete('cascade');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('serial');
            $table->date('buy_at');
            $table->date('salvage_at')->nullable();
            $table->string('qrcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('furniture');
    }
}
