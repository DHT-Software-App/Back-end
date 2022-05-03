<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email_address', 100)->unique();
            $table->string('contact_1', 50);
            $table->string('contact_2', 50);
            $table->string('state', 45);
            $table->string('street', 45);
            $table->string('city', 45);
            $table->unsignedInteger('zip');
            $table->enum('status',['active','desactive'])->default('desactive');
           
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
        Schema::dropIfExists('employees');
    }
}
