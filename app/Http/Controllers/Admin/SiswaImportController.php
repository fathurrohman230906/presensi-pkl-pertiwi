<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaImportController extends Controller
{
    public function importDataSiswa(Request $request) 
    {
       $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        
        Excel::import(new SiswaImport, $request->file('file'));
        return redirect()->route('admin.siswa')->with('success', 'All good!');
    }
}
