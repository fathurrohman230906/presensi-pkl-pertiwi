<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerusahaanControllers extends Controller
{
    public function index() {
      return view("page.admin.data-perusahaan", [
        'titlePage' => 'Data Perusahaan',
      ]);
    }
}
