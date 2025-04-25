<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaRTRWController extends Controller
{
    public function index(Request $request)
    {

        // Breadcrumb data

        $breadcrumb = (object) [
            'title' => 'PETA RENCANA TATA RUANG WILAYAH CADANGAN DAN POTENSI BAHAN BAKU SIG',
            'list' => ['Home', 'Peta Geologi']
        ];

        // Page data
        $page = (object)[
            'title' => ''
        ];

        // Active menu identifier
        $activeMenu = 'petartrw';

        return view('Superadmin.petartrw.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
        ]);
    }
}
