<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->decimal('price', 10, 2, true);
            $table->char('unit', 5);
            $table->enum('item_type', ['Service', 'Machine']);
            $table->enum('category', ['Basic', 'Sub-total Equipment & Materials', 'TARP', 'Sub-total Service Labor']);

            $table->foreignId('work_type_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('estimate_items');
    }
}
