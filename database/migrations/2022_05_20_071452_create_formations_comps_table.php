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
        Schema::create('formations_comps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->constrained();
            $table->string('fc_diploma')->nullable();
            $table->string('fc_field')->nullable();
            $table->string('fc_major')->nullable();
            $table->string('fc_origin')->nullable();
            $table->string('fc_diploma_ref')->nullable();
            $table->date('fc_diploma_date')->nullable();
            $table->date('fc_start_date')->nullable();
            $table->date('fc_end_date')->nullable();
            $table->date('fc_phd_register_date')->nullable();
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
        Schema::dropIfExists('formations_comps');
    }
};
