<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AbsensiKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_karyawan', function(){
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_gaji_bulanan');
            $table->string('nama');
            $table->string('divisi');
            $table->integer('tahun');
            $table->string('bulan');
            $table->integer('telat_10_menit');
            $table->integer('telat_20_menit');
            $table->integer('telat_30_menit');
            $table->integer('telat_lebihi_dari_30_menit');
            $table->integer('pulang_lebih_awal');
            $table->integer('tidak_hadir');
            $table->integer('izin');
            $table->integer('sakit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
