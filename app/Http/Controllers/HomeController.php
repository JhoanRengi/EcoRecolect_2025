<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function landing()  { return view('home.landing_page'); }
    public function nosotros() { return view('home.nosotros'); }
    public function planes()   { return view('home.planes'); }
    public function contacto() { return view('home.contacto'); }
}
