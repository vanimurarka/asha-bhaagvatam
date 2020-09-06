<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChapteridToEditedchaptertext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edited_chaptertext', function (Blueprint $table) {
            $table->tinyInteger('chapterid')->after('originalId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('edited_chaptertext', function (Blueprint $table) {
            $table->dropColumn('chapterid');
        });
    }
}
