<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekerEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seeker_education', function (Blueprint $table) {
            $table->id();
            $table->biginteger('seeker_id');
            $table->string('degree')->nullable();
            $table->string('major_subject')->nullable();
            $table->string('school')->nullable();
            $table->boolean('is_current')->default(0);
            $table->string('location')->nullable();
            $table->integer('from')->nullable();
            $table->integer('to')->nullable();
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
        Schema::dropIfExists('seeker_education');
    }
}
