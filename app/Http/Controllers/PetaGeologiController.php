<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaGeologiController extends Controller
{
    public function index(Request $request)
    {

        // Breadcrumb data

        $breadcrumb = (object) [
            'title' => 'PETA GEOLOGI CADANGAN DAN POTENSI BAHAN BAKU SIG',
            'list' => ['Home', 'Peta Geologi']
        ];

        // Page data
        $page = (object)[
            'title' => ''
        ];

        // Active menu identifier
        $activeMenu = 'petageologi';
        
        return view('Superadmin.petageologi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }

}
