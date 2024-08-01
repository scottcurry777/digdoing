<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations_interests', function (Blueprint $table) {
            $table->id();
            $table->integer('location_id')->unsigned();
            $table->integer('interest_id')->unsigned();
            $table->integer('thumbs_up')->unsigned()->default(0);
            $table->integer('thumbs_down')->unsigned()->default(0);
            $table->decimal('rating', 3, 2)->nullable()->default(null);
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
        Schema::dropIfExists('locations_interests');
    }
}
