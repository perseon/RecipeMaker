<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ImportsController extends Controller
{
    //
    public function index(){
        return Inertia::render('Imports/Index');
    }
}
