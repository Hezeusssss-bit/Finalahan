<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idps', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->integer('age');
            $table->string('gender');
            $table->date('birth_date')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('original_address');
            $table->date('displacement_date');
            $table->foreignId('facility_id')->nullable()->constrained()->onDelete('set null');
            $table->date('return_date')->nullable();
            $table->text('relocation_address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('education_level')->nullable();
            $table->boolean('has_special_needs')->default(false);
            $table->text('special_needs_details')->nullable();
            $table->timestamp('released_at')->nullable();
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
        Schema::dropIfExists('idps');
    }
}
