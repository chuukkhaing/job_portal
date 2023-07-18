<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekerExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seeker_experiences', function (Blueprint $table) {
            $table->id();
            $table->biginteger('seeker_id');
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->integer('main_functional_area_id')->nullable();
            $table->integer('sub_functional_area_id')->nullable();
            $table->string('career_level')->nullable();
            $table->longtext('job_responsibility')->nullable();
            $table->integer('industry_id')->nullable();
            $table->string('country')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current_job')->default(0);
            $table->boolean('is_experience')->default(0);
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
        Schema::dropIfExists('seeker_experiences');
    }
}
