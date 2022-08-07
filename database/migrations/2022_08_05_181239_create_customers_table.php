<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('insured_firstname', 50)->nullable();
            $table->string('insured_lastname', 50)->nullable();
            $table->string('email_address', 100);
            $table->string('state', 45);
            $table->string('street', 45);
            $table->string('city', 45);
            $table->string('zip');
            $table->boolean('has_insured');
            $table->json('contacts')->default(json_encode([]));
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
        Schema::dropIfExists('customers');
    }
}
