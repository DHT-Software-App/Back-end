<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryInsuranceCompanyEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_insurance_company_email', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('id_insurance_company');
            $table->string('email');
            $table->boolean('email_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_insurance_company')->references('id')->on('dry_insurance_company');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_insurance_company_email');
    }
}
