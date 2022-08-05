<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email_address_1', 100);
            $table->string('email_address_2', 100);
            $table->string('contact_1', 50);
            $table->string('contact_2', 50);
            $table->string('state', 45);
            $table->string('street', 45);
            $table->string('city', 45);
            $table->string('zip');
            $table->string('company', 75);
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
        Schema::dropIfExists('clients');
    }
}
