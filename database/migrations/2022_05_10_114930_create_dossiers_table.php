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
        Schema::create('dossiers', function (Blueprint $table) {
            // Folder informations
            $table->id();
            $table->string('status');
            $table->string('is_conformed')->nullable();
            $table->string('current_tab')->default(1);

            //foreign IDs
            $table->foreignId('session_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('besoin_id')->nullable()->constrained();

            //files

            // personal informations of the candidate
            $table->string('name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('family_name_ar')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_family_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birthplace')->nullable();
            $table->boolean('isMan')->nullable();
            $table->string('nationality')->nullable();
            $table->string('id_card')->nullable();
            $table->boolean('isMarried')->nullable();
            $table->integer('children_number')->nullable();
            $table->string('disability_type')->nullable();
            $table->string('commune')->nullable();
            $table->string('wilaya')->nullable();
            $table->string('adresse')->nullable();
            $table->string('tel')->nullable();
            $table->string('national_service')->nullable();
            $table->string('doc_num')->nullable();
            $table->date('doc_issued_date')->nullable();

            // diploma informations
            $table->string('diploma_name')->nullable();
            $table->string('diploma_mark')->nullable();
            $table->string('diploma_sector')->nullable();
            $table->string('diploma_speciality')->nullable();
            $table->date('diploma_date')->nullable();
            $table->string('diploma_number')->nullable();
            $table->date('diploma_start_date')->nullable();
            $table->date('diploma_end_date')->nullable();
            $table->string('diploma_institution')->nullable();

            // Situation infromations
            $table->string('sp_workplace')->nullable();
            $table->date('sp_first_nomination_date')->nullable();
            $table->date('sp_nomination_date')->nullable();
            $table->string('sp_category')->nullable();
            $table->string('sp_echelon')->nullable();
            $table->string('sp_agreement_ref')->nullable();
            $table->date('sp_agreement_date')->nullable();
            $table->string('sp_authority')->nullable();
            $table->string('sp_adresse')->nullable();
            $table->string('sp_tel')->nullable();
            $table->string('sp_fax')->nullable();
            $table->string('sp_email')->nullable();


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
        Schema::dropIfExists('dossiers');
    }
};
