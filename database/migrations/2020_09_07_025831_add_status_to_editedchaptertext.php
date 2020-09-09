<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToEditedchaptertext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('edited_chaptertext', function (Blueprint $table) {
            // 0 -- pending approval
            // 1 -- accepted and original edited
            // -1 -- rejected
            $table->tinyInteger('status')->after('chapterid')->default(0);
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
            $table->dropColumn('status');
        });
    }
}
