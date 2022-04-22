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
        Schema::create('temp_dossiers', function (Blueprint $table) {
            $table->id();

            //!what about the SDP ??
            //foreign key 'every user can have a folder'

            $table->foreignId('user_id')->constrained();

            // personal informations about candidats
            // $table->string('name_ar',80);
            // $table->string('family_name_ar',80);
            // $table->string('father_name',80);
            // $table->string('mother_family_name',80);
            // $table->string('mother_name',80);
            // $table->date('birth_date');
            // $table->string('birthplace',100);
            // $table->boolean('isMan');
            // $table->string('nationality',50);
            // $table->string('id_card',25);
            // $table->boolean('isMarried');
            // $table->integer('children_number')->nullable(); //stay optional
            // $table->string('disability_type',100);
            // $table->string('commune',50);
            // $table->string('wilaya',50);
            // $table->string('adresse',80);
            // $table->string('tel',10);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_dossiers');
    }
};
