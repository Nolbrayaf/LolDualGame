<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchSummariesTable extends Migration
{
    public function up()
    {
        Schema::create('match_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('match_result');
            $table->string('opponent');
            $table->unsignedBigInteger('champion_used_id');
            $table->foreign('champion_used_id')->references('id')->on('champions');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('match_summaries');
    }
}

