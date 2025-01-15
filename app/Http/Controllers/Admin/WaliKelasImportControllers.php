<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\WaliKelasImport;
use Maatwebsite\Excel\Facades\Excel;

class WaliKelasImportControllers extends Controller
{
    public function importDataWaliKelas(Request $request) 
    {
       $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        
        Excel::import(new WaliKelasImport, $request->file('file'));
        return redirect()->route('admin.wali.kelas')->with('success', 'Data berhasil di tambahkan!');
    }
}
