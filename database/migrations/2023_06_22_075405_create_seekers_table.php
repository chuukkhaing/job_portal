<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seekers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('country')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('township_id')->nullable();
            $table->longtext('address_detail')->nullable();
            $table->string('nationality')->nullable();
            $table->string('nrc')->nullable();
            $table->string('id_card')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('job_title')->nullable();
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('main_functional_area_id')->nullable();
            $table->string('sub_functional_area_id')->nullable();
            $table->string('job_type')->nullable();
            $table->string('career_level')->nullable();
            $table->biginteger('preferred_salary')->nullable();
            $table->integer('industry_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_immediate_available')->default(0);
            $table->bigInteger('number_of_profile_view')->default(0);
            $table->longtext('summary')->nullable();
            $table->integer('percentage')->default(0);
            $table->boolean('is_verify')->default(0);
            $table->boolean('email_verified')->default(0);
            $table->datetime('register_at')->nullable();
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
        Schema::dropIfExists('seekers');
    }
}
