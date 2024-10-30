<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardControllerMultiuser extends Controller
{
    public function DashboardAdmin()
    {
        return view('admin.home', [
            "title" => "dashboard"
        ]);
    }

    public function DashboardSiswa()
    {
        return view('siswa.dashboard', [
            "title" => "dashboard"
        ]);
    }

    public function DashboardPembimbing()
    {
        return view('pembimbing.dashboard', [
            "title" => "dashboard"
        ]);
    }
    
    public function DashboardWaliKelas()
    {
        return view('waliKelas.dashboard', [
            "title" => "dashboard"
        ]);
    }
}
