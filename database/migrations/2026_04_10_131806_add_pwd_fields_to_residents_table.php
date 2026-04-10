<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPwdFieldsToResidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('residents', function (Blueprint $table) {
            // Add PWD fields for each family member
            $table->boolean('family_head_pwd')->default(false)->after('pwd_in_family')->comment('Whether the family head is a PWD');
            $table->boolean('wife_pwd')->default(false)->after('family_head_pwd')->comment('Whether the wife is a PWD');
            $table->boolean('son_pwd')->default(false)->after('wife_pwd')->comment('Whether the son is a PWD');
            $table->boolean('daughter_pwd')->default(false)->after('son_pwd')->comment('Whether the daughter is a PWD');
            $table->boolean('grandmother_pwd')->default(false)->after('daughter_pwd')->comment('Whether the grandmother is a PWD');
            $table->boolean('grandfather_pwd')->default(false)->after('grandmother_pwd')->comment('Whether the grandfather is a PWD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('residents', function (Blueprint $table) {
            // Remove PWD fields
            $table->dropColumn(['family_head_pwd', 'wife_pwd', 'son_pwd', 'daughter_pwd', 'grandmother_pwd', 'grandfather_pwd']);
        });
    }
}
