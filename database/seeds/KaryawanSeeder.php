<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 0; $i <= 10; $i++){
            DB::table('karyawan')->insert([
                'id_divisi' => '1',
                'nama' => $faker->name,
                'alamat' => $faker->address,
                'email' => $faker->email,
            ]);
        }
    }
}
