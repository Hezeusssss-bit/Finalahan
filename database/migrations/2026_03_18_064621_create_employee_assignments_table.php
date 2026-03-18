<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('evacuation_center');
            $table->string('shift')->default('morning'); // morning, afternoon, night
            $table->date('assignment_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->text('responsibilities')->nullable(); // Organize residents, manage supplies, etc.
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('employee_assignments');
    }
}
