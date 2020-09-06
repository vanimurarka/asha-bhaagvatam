<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexToEditedchaptertext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edited_chaptertext', function (Blueprint $table) {
            $table->unique(['userid','originalId'],'unique_user_line_edits');
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
            $table->dropUnique('unique_user_line_edits');
        });
    }
}
