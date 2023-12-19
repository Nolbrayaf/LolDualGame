<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionsTable extends Migration
{
    public function up()
    {
        Schema::create('champions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key');
            $table->string('title');
            $table->json('info');
            $table->json('tags');
            $table->string('partype');
            $table->json('stats');
            $table->integer('difficulty');
            $table->string('splash_art_path');
            $table->string('square_art_path');
            $table->string('dual_art_path');
            $table->text('description');
            $table->integer('required_level');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('champions');
    }
}

