<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnwantedFieldsFromEmployeeAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_assignments', function (Blueprint $table) {
            $table->dropColumn(['shift', 'assignment_date', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_assignments', function (Blueprint $table) {
            $table->string('shift')->default('morning');
            $table->date('assignment_date');
            $table->time('start_time');
            $table->time('end_time');
        });
    }
}
