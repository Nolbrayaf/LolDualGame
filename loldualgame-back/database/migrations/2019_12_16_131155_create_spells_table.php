<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpellsTable extends Migration
{
    public function up()
    {
        Schema::create('spells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('champion_id');
            $table->foreign('champion_id')->references('id')->on('champions');
            $table->string('name');
            $table->text('description');
            $table->integer('max_rank')->nullable();
            $table->string('image_path');
            $table->json('cooldowns')->nullable();
            $table->json('cost')->nullable();
            $table->json('effect')->nullable();
            $table->boolean('is_passive')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spells');
    }
}


