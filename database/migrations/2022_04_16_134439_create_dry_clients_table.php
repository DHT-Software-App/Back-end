<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('person_contact',70);
            $table->string('company');
            $table->string('email',100);
            $table->string('street',50);
            $table->unsignedBigInteger('id_city')->references('id')->on('dry_cities')->onDelete('cascade');
            $table->unsignedBigInteger('id_state')->references('id')->on('dry_states')->onDelete('cascade');
            $table->integer('zip');
            $table->boolean('client_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_city')->references('id')->on('dry_cities');
            $table->foreign('id_state')->references('id')->on('dry_states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_clients');
    }
}
