<?php

namespace App\Http\Controllers;

class EducationController extends Controller
{
    public function index()
    {
        return view('edukasi.index');
    }

    public function polaAsuh()
    {
        return view('edukasi.pola-asuh');
    }

    public function phbs()
    {
        return view('edukasi.phbs');
    }

    public function kehamilan()
    {
        return view('edukasi.kehamilan');
    }
}
