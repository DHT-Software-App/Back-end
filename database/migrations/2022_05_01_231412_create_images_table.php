<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Polymorphic Table
        Schema::create('images', function (Blueprint $table) {
            $table->longText('url');
            $table->unsignedInteger('imageable_id');
            $table->string('imageable_type');
            $table->unsignedBigInteger('size');
            $table->string('extension', 8);

            $table->primary(['imageable_id', 'imageable_type']);

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
        Schema::dropIfExists('images');
    }
}
