<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GajiBulananMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji_bulanan', function(Blueprint $table){
            $table->id();
            $table->integer('id_karyawan');
            $table->integer('id_divisi');
            $table->integer('id_tanggal');
            $table->integer('tahun');
            $table->string('bulan');
            $table->string('gaji_pokok');
            $table->string('potongan');
            $table->timestamp('created_at');
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
