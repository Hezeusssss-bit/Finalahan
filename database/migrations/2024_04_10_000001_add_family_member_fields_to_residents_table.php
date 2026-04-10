<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // Add family member full name fields
            $table->string('family_head_fullname')->nullable()->after('name');
            $table->integer('family_head_age')->nullable()->after('family_head_fullname');
            $table->date('family_head_birthdate')->nullable()->after('family_head_age');
            
            $table->string('wife_fullname')->nullable()->after('family_head_birthdate');
            $table->integer('wife_age')->nullable()->after('wife_fullname');
            $table->date('wife_birthdate')->nullable()->after('wife_age');
            
            $table->string('son_fullname')->nullable()->after('wife_birthdate');
            $table->integer('son_age')->nullable()->after('son_fullname');
            $table->date('son_birthdate')->nullable()->after('son_age');
            
            $table->string('daughter_fullname')->nullable()->after('son_birthdate');
            $table->integer('daughter_age')->nullable()->after('daughter_fullname');
            $table->date('daughter_birthdate')->nullable()->after('daughter_age');
            
            $table->string('grandmother_fullname')->nullable()->after('daughter_birthdate');
            $table->integer('grandmother_age')->nullable()->after('grandmother_fullname');
            $table->date('grandmother_birthdate')->nullable()->after('grandmother_age');
            
            $table->string('grandfather_fullname')->nullable()->after('grandmother_birthdate');
            $table->integer('grandfather_age')->nullable()->after('grandfather_fullname');
            $table->date('grandfather_birthdate')->nullable()->after('grandfather_age');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            // Remove all family member fields
            $table->dropColumn([
                'family_head_fullname',
                'family_head_age',
                'family_head_birthdate',
                'wife_fullname',
                'wife_age',
                'wife_birthdate',
                'son_fullname',
                'son_age',
                'son_birthdate',
                'daughter_fullname',
                'daughter_age',
                'daughter_birthdate',
                'grandmother_fullname',
                'grandmother_age',
                'grandmother_birthdate',
                'grandfather_fullname',
                'grandfather_age',
                'grandfather_birthdate'
            ]);
        });
    }
};
