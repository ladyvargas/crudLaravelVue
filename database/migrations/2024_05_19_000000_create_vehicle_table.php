<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('vehicle', function (Blueprint $table) {
        $table->id();
        $table->string('brand');
        $table->string('model');
        $table->string('license_plate');
        $table->integer('year');
        $table->unsignedBigInteger('id_user'); // Use unsigned big integer for foreign key
        $table->float('price');
        $table->timestamps();

        // Define foreign key constraint
        $table->foreign('id_user')->references('id')->on('users');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle');
    }
}
