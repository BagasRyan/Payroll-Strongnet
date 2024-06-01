<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KaryawanModel extends Model
{
    protected $table = 'karyawan';

    public function getData(){
        return DB::table('karyawan')->get();
    }

}
