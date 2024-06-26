<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KaryawanMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function(Blueprint $table){
            $table->id();
            $table->integer('id_divisi');
            $table->string('nama');
            $table->text('alamat');
            $table->integer('no_telepon');
            $table->string('email');
            $table->string('gaji_pokok');
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
