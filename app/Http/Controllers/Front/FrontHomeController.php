<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class FrontHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.front');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages/front/home/index');
    }

    public function vehicleCreate()
    {
        //Get Vehicles
        $all_vehicles = [];
        $vehicles_count = Vehicle::count();
        if($vehicles_count > 0){
            $get_vehicles = Vehicle::all();
            $all_vehicles = $get_vehicles;
        }
        
        return view('pages/front/vehicle/create', compact('all_vehicles'));
    }

    public function vehicleShow()
    {
        return view('pages/front/vehicle/index');
    }
}
