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
            $table->json('resep_obat');
            $table->text('catatan');
            $table->boolean('status')->nullable();
            $table->string('total_harga');
            $table->timestamp('selesai_at');
            $table->timestamp('diambil_at');
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
