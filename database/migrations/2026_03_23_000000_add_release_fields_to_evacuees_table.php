<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleaseFieldsToEvacueesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evacuees', function (Blueprint $table) {
            $table->timestamp('released_at')->nullable();
            $table->time('release_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evacuees', function (Blueprint $table) {
            $table->dropColumn(['released_at', 'release_time']);
        });
    }
}
