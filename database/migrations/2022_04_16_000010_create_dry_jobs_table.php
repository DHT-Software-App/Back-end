<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_customers')->references('id')->on('dry_customers')->onDelete('cascade');
            $table->unsignedBigInteger('id_insurance_company')->references('id')->on('dry_insurance_company')->onDelete('cascade');
            $table->string('policy_number',50);
            $table->string('claim_number',50);
            $table->date('date_loss');
            $table->unsignedBigInteger('id_type_loss');
            $table->text('text');
            $table->unsignedBigInteger('referred_by');
            $table->unsignedBigInteger('id_job_status')->references('id')->on('dry_job_status')->onDelete('cascade');
            $table->unsignedBigInteger('id_type_work')->references('id')->on('dry_type_work')->onDelete('cascade');
            $table->boolean('job_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();

         
         
         //   $table->foreign('id_job_status')->references('id')->on('dry_job_status');
         //   $table->foreign('id_type_work')->references('id')->on('dry_type_work');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_jobs');
    }
}
