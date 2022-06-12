<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryJobStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_job_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type_job');
            $table->boolean('job_status',1);
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
        Schema::dropIfExists('dry_job_status');
    }
}
