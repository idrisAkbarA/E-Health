<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratRujukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_rujukan', function (Blueprint $table) {
            $table->id();
            $table->integer('dokter_id');
            $table->integer('pasien_id');
            $table->text('diagnosa');
            $table->text('pengobatan');
            $table->text('keadaan');
            $table->string('tujuan');
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
        Schema::dropIfExists('surat_rujukan');
    }
}
