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
            $table->string('slug')->nullable();
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
            $table->string('country')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('township_id')->nullable();
            $table->longtext('job_description')->nullable();
            $table->longtext('job_requirement')->nullable();
            $table->longtext('benefit')->nullable();
            $table->longtext('job_highlight')->nullable();
            $table->boolean('hide_salary')->default(0);
            $table->boolean('hide_company')->default(0);
            $table->integer('no_of_candidate')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('recruiter_name')->nullable();
            $table->string('recruiter_email')->nullable();
            $table->string('status')->nullable();
            $table->integer('approved_by')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->date('expired_at')->nullable();
            $table->date('approved_at')->nullable();
            $table->date('rejected_at')->nullable();
            $table->string('job_post_type');
            $table->integer('total_point');
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
