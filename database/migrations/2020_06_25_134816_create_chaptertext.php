<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChaptertext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapterText', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('chapterId');
            $table->string('type');
            $table->tinyInteger('number');
            $table->tinyInteger('lineNumber');
            $table->longText('text1');
            $table->longText('text2');
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
        Schema::dropIfExists('chapterText');
    }
}
