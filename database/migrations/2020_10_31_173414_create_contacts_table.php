<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->morphs('contactable');
            $table->string('suite')->nullable();
            $table->string('num')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('pc', 9)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('relationship', 50)->nullable();
            $table->set('type', ['primary', 'emergency', 'other']);
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
        Schema::dropIfExists('contacts');
    }
}
