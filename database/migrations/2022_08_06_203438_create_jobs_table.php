<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('policy_number');
            $table->string('claim_number');
            $table->string('notes');
            $table->dateTime('date_of_loss');
            $table->string('type_of_loss');
            $table->string('status')->default('new');
            $table->string('state', 4000);
            $table->string('street', 4000);
            $table->string('city', 4000);
            $table->integer('zip', 4000);
            $table->integer('employee_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('work_type_id')->unsigned();
            $table->integer('insurance_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('work_type_id')->references('id')->on('work_types')->onDelete('cascade');
            $table->foreign('insurance_id')->references('id')->on('work_types')->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
    }
}
