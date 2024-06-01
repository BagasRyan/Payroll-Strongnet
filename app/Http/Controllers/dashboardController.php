<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KaryawanModel;

class dashboardController extends Controller
{
    public function index(){

        // $model = KaryawanModel::all();
        // $karyawan = $model->getData();

        // dd($model);
        return view('dashboard');
    }

}
