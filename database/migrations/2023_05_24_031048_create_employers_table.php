<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->integer('employer_id')->nullable();
            $table->string('logo')->nullable();
            $table->string('background')->nullable();
            $table->string('qr')->nullable();
            $table->string('name')->nullable();
			$table->string('email')->nullable();
            $table->string('password');
			$table->bigInteger('industry_id')->default(0);
			$table->bigInteger('ownership_type_id')->default(0);
            $table->string('type_of_employer')->nullable();
			$table->longText('summary')->nullable();
			$table->longText('value')->nullable();
			$table->integer('no_of_offices')->nullable();
			$table->string('website')->nullable();
			$table->string('no_of_employees')->nullable();
			$table->boolean('is_active')->default(1);
			$table->string('slug')->nullable();
			$table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->boolean('email_verified')->default(0);
            $table->bigInteger('package_id')->nullable();
			$table->datetime('package_start_date')->nullable();
			$table->datetime('package_end_date')->nullable();
			$table->datetime('register_at')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->integer('deleted_by')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('employers');
    }
}
