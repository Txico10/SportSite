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
            $table->unsignedBigInteger('furniture_type_id');
            $table->unsignedBigInteger('real_state_id');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('serial');
            $table->date('buy_at');
            $table->date('salvage_at')->nullable();
            $table->string('qrcode')->nullable();
            $table->timestamps();
            $table->foreign('furniture_type_id')->references('id')->on('furniture_types')->onDelete('cascade');
            $table->foreign('real_state_id')->references('id')->on('real_states')->onDelete('cascade');
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
