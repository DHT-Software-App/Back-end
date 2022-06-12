<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryClientsEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_clients_email', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_client')->references('id')->on('dry_clients')->onDelete('cascade');
            $table->string('email');
            $table->boolean('email_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_client')->references('id')->on('dry_clients');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_clients_email');
    }
}
