<?php

namespace App\Http\Controllers;

class StuntingController extends Controller
{
    public function index()
    {
        return view('stunting');
    }

    public function cekRisiko()
    {
        return view('assessment');
    }
}
