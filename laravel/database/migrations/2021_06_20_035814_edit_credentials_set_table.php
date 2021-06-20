<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditCredentialsSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credential_sets', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
            $table->renameColumn('created_by', 'user_id');
            $table->dropColumn('updated_by');
            $table->dropColumn('deleted_by');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credential_sets', function (Blueprint $table) {
            $table->renameColumn('title', 'name');
            $table->renameColumn('user_id', 'created_by');
            $table->string('updated_by');
            $table->string('deleted_by');
        });
    }
}
