<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->integer('employer_id')->nullable();
            $table->string('job_title');
            $table->integer('main_functional_area_id')->nullable();
            $table->integer('sub_functional_area_id')->nullable();
            $table->integer('industry_id')->nullable();
            $table->string('career_level')->nullable();
            $table->string('job_type')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('degree')->nullable();
            $table->string('gender')->nullable();
            $table->string('currency')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('salary_status')->nullable();
            $table->string('country')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('township_id')->nullable();
            $table->longtext('job_description')->nullable();
            $table->longtext('benefit')->nullable();
            $table->longtext('job_higlight')->nullable();
            $table->longtext('requirement_and_skill')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('job_posts');
    }
}
