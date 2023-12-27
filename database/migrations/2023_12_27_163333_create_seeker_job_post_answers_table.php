<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekerJobPostAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seeker_job_post_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('seeker_id');
            $table->integer('job_post_id');
            $table->integer('job_apply_id');
            $table->integer('job_post_question_id');
            $table->longtext('answer');
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
        Schema::dropIfExists('seeker_job_post_answers');
    }
}
