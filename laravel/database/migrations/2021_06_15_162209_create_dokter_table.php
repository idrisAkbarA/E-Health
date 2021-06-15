<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('poli_id');
            $table->string('tempat_tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->enum('agama', ['Islam', 'Kristen', 'Konghucu', 'Budha', 'Hindu'])->nullable();
            $table->json('pendidikan')->nullable();
            $table->string('spesialis')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->boolean('is_aktif')->default(false);
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
        Schema::dropIfExists('dokter');
    }
}
