<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_sales_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('note_id')->default(0);
            $table->integer('item_id')->default(0);
            $table->string('quantity');
            $table->string('total');
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
        Schema::dropIfExists('note_sales_items');
    }
};
