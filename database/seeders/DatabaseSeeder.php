<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Admin::create([
            'email' => 'admin@gmail.com',
            'password' => Bcrypt('admin123'),
            'nm_lengkap' => 'Admin 1',
            'jk' => 'L',
            'agama' => 'Islam',
            'foto' => 'test@example.jpg',
            'alamat' => 'Testing Alamat',
        ]);
        
        //rpl
        \App\Models\Jurusan::create([
            'nm_jurusan' => 'Rekayasa Perangkat Lunak',
        ]);
        //lp
        \App\Models\Jurusan::create([
            'nm_jurusan' => 'Layanan Perbankan',
        ]);
        //tkj
        \App\Models\Jurusan::create([
            'nm_jurusan' => 'Teknik Jaringan dan Komputer',
        ]);
        //tkr
        \App\Models\Jurusan::create([
            'nm_jurusan' => 'Teknik Kendaraan Ringan',
        ]);
        //to
        \App\Models\Jurusan::create([
            'nm_jurusan' => 'Teknik Otomotif',
        ]);
        //tbsm
        \App\Models\Jurusan::create([
            'nm_jurusan' => 'Teknik Bisnis Sepeda Motor',
        ]);
    }
}
