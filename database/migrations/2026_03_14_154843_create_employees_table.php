<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('position');
            $table->string('department');
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->date('hire_date')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'department']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
