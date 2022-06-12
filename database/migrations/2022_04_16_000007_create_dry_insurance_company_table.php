<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryInsuranceCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_insurance_company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company');
            $table->string('street',50);
            $table->unsignedBigInteger('id_city')->references('id')->on('dry_cities')->onDelete('cascade');
            $table->unsignedBigInteger('id_state')->references('id')->on('dry_states')->onDelete('cascade');
            $table->integer('zip');
            $table->boolean('insuredcompany_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();

          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_insurance_company');
    }
}
