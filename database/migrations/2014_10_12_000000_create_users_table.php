<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('identity_card');
            $table->date('birthday');
            $table->enum('gender', ['male', 'female']);
            $table->string('address');
            $table->integer('district_id');
            $table->integer('subdistrict_id');
            $table->integer('disability_id');
            $table->string('disability_detail');
            $table->string('academic_level');
            $table->string('specialize')->nullable();
            $table->boolean('labor_ability');
            $table->string('employment_status')->nullable();
            $table->integer('income')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
