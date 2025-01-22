<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembimbing;

class KelolaPembimbingAdminControllers extends Controller
{
    public function index() {
        $titlePage = "Kelola Pembimbing";
    
        $pembimbing = Pembimbing::with('jurusan')->get();
    
        return view("page.admin.data-pembimbing.data-pembimbing", compact('titlePage', 'pembimbing'));
    }
}
