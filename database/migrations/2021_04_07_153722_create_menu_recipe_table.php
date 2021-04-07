<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_recipe', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_id')->unsigned();
            $table->integer('recipe_id')->unsigned();
            $table->integer('cant');
            $table->timestamps();
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus');
            $table->foreign('recipe_id')
                ->references('id')
                ->on('recipes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_recipe');
    }
}
