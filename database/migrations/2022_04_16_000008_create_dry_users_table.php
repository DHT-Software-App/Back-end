<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDryUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('dry_users', function (Blueprint $table) 
        {
            $table->bigIncrements('id');
          //  $table->string('first_name',50);
          //  $table->string('last_name',50);
          //  $table->char('sex',1);
            $table->boolean('block',1);
            $table->text('lock_reason');
            $table->text('photo');
            $table->string('code_activation',50);
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',100);
            $table->boolean("access_system",0);
            $table->boolean("first_use");
            $table->rememberToken();
            $table->boolean('user_status',1);
            $table->boolean('user_deleted',0);
            $table->boolean('user_updated',0);
            $table->boolean('user_created',0);
            $table->string('role',20);
            $table->string('origin',30);
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
        Schema::dropIfExists('dry_users');
    }
}
