<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function Presensi() {
        return view('siswa.Presensi.internship-presensi');
    }

    public function ProsesPresensi(Request $request) {
        dd($request->all());
        $lokasi = json_decode($request['lokasi'], true); // true to return an associative array
        // Now you can access the latitude like this:
        $latitude = $lokasi['latitude'];
        $longitude = $lokasi['longitude'];
        // dd($longitude);
    }
}
