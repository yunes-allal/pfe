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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_id')->constrained();
            $table->float('entretien_1')->nullable();
            $table->float('entretien_2')->nullable();
            $table->float('entretien_3')->nullable();
            $table->float('entretien_4')->nullable();
            $table->float('ts_1')->nullable();
            $table->float('ts_2')->nullable();
            $table->float('ts_3')->nullable();
            $table->float('ts_4')->nullable();
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
        Schema::dropIfExists('notes');
    }
};
