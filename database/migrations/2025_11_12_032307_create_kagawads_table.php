<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKagawadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kagawads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('term_start')->nullable();
            $table->string('term_end')->nullable();
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
        Schema::dropIfExists('kagawads');
    }
}
