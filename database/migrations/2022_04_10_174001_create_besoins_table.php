<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('besoins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('sessions');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('sector_id')->constrained('sectors');
            $table->foreignId('speciality_id')->nullable()->constrained('specialities');
            $table->foreignId('subspeciality_id')->nullable()->constrained('subspecialities');
            $table->integer('positions_number');
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
        Schema::dropIfExists('besoins');
    }
};
