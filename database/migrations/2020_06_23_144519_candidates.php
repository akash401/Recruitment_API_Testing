<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Candidates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('candidates', function (Blueprint $table) {
			$table->increments('id');
            $table->string('first_name','40');
            $table->string('last_name','40');
            $table->string('email','100');
            $table->string('contact_number','100');
            $table->tinyInteger('gender');
            $table->string('specialization','200');
            $table->integer('work_ex_year');
			$table->date('candidate_dob');
            $table->string('address','500');
            $table->binary('resume');
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
         Schema::dropIfExists('candidates');
    }
}
