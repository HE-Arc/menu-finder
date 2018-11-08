<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Phaza\LaravelPostgis\Schema\Blueprint;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->unsignedInteger('rate_sum')->nullable();
            $table->unsignedInteger('rate_nb')->nullable();
            $table->point('location')->nullable();
            $table->string('address')->nullable();
            $table->unsignedInteger('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('avatar')->default("default.png");
            $table->string('website')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
}
