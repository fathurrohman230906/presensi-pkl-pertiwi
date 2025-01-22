<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportPembimbing;
use Maatwebsite\Excel\Facades\Excel;

class ImportPembimbingControllers extends Controller
{
    public function importDataPembimbing(Request $request) 
    {
       $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        
        Excel::import(new ImportPembimbing, $request->file('file'));
        return redirect()->route('admin.pembimbing')->with('success', 'Data berhasil di tambahkan!');
    }
}
