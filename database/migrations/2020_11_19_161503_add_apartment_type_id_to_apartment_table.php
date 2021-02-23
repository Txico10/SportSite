<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApartmentTypeIdToApartmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->unsignedBigInteger('apartment_type_id')->after('id');
            $table->foreign('apartment_type_id')->references('id')->on('apartment_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropForeign(['apartment_type_id']);
            $table->dropColumn(['apartment_type_id']);
        });
    }
}
