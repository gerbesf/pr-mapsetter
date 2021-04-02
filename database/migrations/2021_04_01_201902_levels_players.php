<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LevelsPlayers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('map_key');      // map
            $table->string('size');         // player_size
            $table->string('game_mode');    // ins, cq
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('levels_players');
    }
}
