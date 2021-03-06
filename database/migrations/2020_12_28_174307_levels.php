<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Levels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Name');
            $table->string('Key');
            $table->string('Slug');
            $table->string('Resolution');
            $table->string('Image');
            $table->string('Size');
            $table->string('Color');
            $table->json('Layouts');
            $table->boolean('Ww2')->nullable();
            $table->boolean('Aas')->nullable();
            $table->boolean('Vehicle')->nullable();
            $table->boolean('Insurgency')->nullable();
            $table->boolean('Skirmish')->nullable();
            $table->boolean('Cnc')->nullable();
            $table->boolean('Vietnam')->nullable();
            $table->string('Status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels');
    }
}
