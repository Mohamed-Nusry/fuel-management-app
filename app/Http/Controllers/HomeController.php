<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = [];

        $suppliers = [];

        $materials = [];

        $kanbans = [];

        return view('home', [
            'departments' => $departments,
            'suppliers' => $suppliers,
            'materials' => $materials,
            'kanbans' => $kanbans
        ]);
    }
}