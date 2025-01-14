<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WaliKelasImportControllers extends Controller
{
    public function importDataSiswa(Request $request) 
    {
       $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        
        Excel::import(new SiswaImport, $request->file('file'));
        return redirect()->route('admin.siswa')->with('success', 'Data berhasil di tambahkan!');
    }
}
