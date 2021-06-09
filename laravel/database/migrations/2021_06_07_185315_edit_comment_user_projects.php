<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCommentUserProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_projects', function (Blueprint $table) {
            $table->boolean('type')
                  ->default(3)
                  ->comment('1 - general access, 2 - extended access, 3 - You are owner')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_projects', function (Blueprint $table) {
            $table->boolean('type')
                  ->default(3)
                  ->comment('1 - owner, 2 - extended rights, 3 - general')
                  ->change();
        });
    }
}
