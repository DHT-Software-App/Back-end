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
            $table->id();
            $table->string('policy_number', 75);
            $table->string('claim_number', 75);
            $table->longText('notes');
            $table->dateTime('date_of_loss');
            $table->string('type_of_loss', 75);
            $table->enum('status', ['new', 'on going', 'completed'])->default('new');
            $table->string('state', 45);
            $table->string('street', 45);
            $table->string('city', 45);
            $table->string('zip');
            $table->string('company', 75);

            $table->foreignId('client_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('work_type_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('insurance_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

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
