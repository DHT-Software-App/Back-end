<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryCaledarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dry_caledar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_jobs')->references('id')->on('dry_jobs')->onDelete('cascade');
            $table->unsignedBigInteger('id_technician')->references('id')->on('dry_employee')->onDelete('cascade');
            $table->date('date_start_job');
            $table->date('date_finish_job');
            $table->text('note');
            $table->boolean('calendar_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_jobs')->references('id')->on('dry_jobs');
        //    $table->foreign('id_technician')->references('id')->on('dry_employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dry_caledar');
    }
}
