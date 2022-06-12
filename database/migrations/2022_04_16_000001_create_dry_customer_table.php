<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('email',100);
            $table->string('street',50);
            $table->unsignedBigInteger('id_city')->references('id')->on('dry_cities')->onDelete('cascade');
            $table->unsignedBigInteger('id_state')->references('id')->on('dry_states')->onDelete('cascade');
            $table->integer('zip');
            $table->boolean('customer_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();
            $table->unique('email');

         //   $table->foreign('id')->references('id_customers')->on('dry_jobs');
          
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_customers');
    }
}
