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
        $config = config('listmaker.tables');

        Schema::create($config['lists-table'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create($config['list-items-table'], function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('list_id');
            $table->enum('type', ['item', 'divider']);
            $table->string('route')->default('#');
            $table->string('icon')->default('');
            $table->string('display');
            $table->integer('order');
            $table->timestamps();

            $table->foreign('list_id')->references('id')->on('lists')->onUpdate('cascade')->onDelete('cascade');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $config = config('listmaker.tables');
        Schema::dropIfExists($config['lists-table']);
        Schema::dropIfExists($config['list-items-table']);
    }
}
