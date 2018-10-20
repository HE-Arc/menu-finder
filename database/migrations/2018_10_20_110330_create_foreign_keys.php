<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dishes', function (Blueprint $table) {

          $table->foreign('menu_id')
            ->references('id')->on('menus')
            ->onDelete('cascade');

        });
        Schema::table('menus', function (Blueprint $table) {

            $table->foreign('restaurant_id')
              ->references('id')->on('restaurants')
              ->onDelete('cascade');
            $table->foreign('category_id')
              ->references('id')->on('categories')
              ->onDelete('cascade');
        });
        Schema::table('restaurants', function (Blueprint $table) {

            $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('dishes', function (Blueprint $table) {

        $table->dropForeign(['menu_id']);
        

      });
      Schema::table('menus', function (Blueprint $table) {

          $table->dropForeign(['restaurant_id']);
          $table->dropForeign(['category_id']);

      });
      Schema::table('restaurants', function (Blueprint $table) {

          $table->dropForeign(['user_id']);


      });
    }
}
