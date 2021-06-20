<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_obat', function (Blueprint $table) {
            $table->id();
            $table->integer('rekam_medis_id')->nullable();
            $table->string('nama')->nullable();
            $table->json('resep_obat');
            $table->text('catatan');
            $table->boolean('status')->nullable();
            $table->string('total_harga');
            $table->timestamp('selesai_at')->nullable();
            $table->timestamp('diambil_at')->nullable();
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
        Schema::dropIfExists('antrian_obat');
    }
}
