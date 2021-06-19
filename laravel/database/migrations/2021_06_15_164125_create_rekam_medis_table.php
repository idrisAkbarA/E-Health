<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekamMedisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->integer('pasien_id');
            $table->integer('dokter_id')->nullable();
            $table->integer('poli_id');
            $table->text('diagnosa')->nullable();
            $table->text('pengobatan')->nullable();
            $table->integer('resep_obat_id')->nullable();
            $table->string('total_biaya')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_bayar')->default(0);
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
        Schema::dropIfExists('rekam_medis');
    }
}
