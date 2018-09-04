<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // The lists table
        Schema::create('lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        // The items table
        Schema::create('list_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('list_id');
            $table->enum('type', ['item', 'divider']);
            $table->string('route')->default('#');
            $table->string('icon')->default('');
            $table->string('display');
            $table->integer('order');
            $table->timestamps();

            $table->foreign('list_id')->references('id')->on('lists')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_items');
        Schema::dropIfExists('lists');
    }
}
