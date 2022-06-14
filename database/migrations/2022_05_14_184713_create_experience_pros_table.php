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
        Schema::create('experience_pros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('ep_institution')->nullable();
            $table->string('ep_workplace')->nullable();
            $table->integer('ep_periode')->nullable();
            $table->string('ep_work_certificate_ref')->nullable();
            $table->date('ep_work_certificate_date')->nullable();
            $table->longText('ep_mark')->nullable();
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
        Schema::dropIfExists('experience_pros');
    }
};
