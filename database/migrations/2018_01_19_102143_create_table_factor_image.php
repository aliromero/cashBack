<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFactorImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factor_image', function (Blueprint $table) {
            $table->unsignedInteger('factor_id')->index();
            $table->unsignedInteger('image_id')->index();
            $table->foreign('factor_id')->references('id')->on('factors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factor_image');
    }
}
