<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_alerts', function (Blueprint $table) {
            $table->id();
            $table->integer('seeker_id');
            $table->string('email')->nullable();
            $table->string('job_title')->nullable();
            $table->string('job_type')->nullable();
            $table->integer('industry_id')->nullable();
            $table->string('career_level')->nullable();
            $table->integer('functional_area_id')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('country')->nullable();
            $table->integer('state_id')->nullable();
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
        Schema::dropIfExists('job_alerts');
    }
}
