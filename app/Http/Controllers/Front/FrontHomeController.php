<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FuelStation;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        try {

            $vehicle_registrations = [];

            $data_count = VehicleRegistration::where('customer_id', Auth::user()->id)->count();

            if($data_count > 0){
                $data = VehicleRegistration::where('customer_id', Auth::user()->id)->with('vehicle')->get();

                $vehicle_registrations = $data;

            }

            return view('pages/front/home/index', compact('vehicle_registrations'));

        } catch (\Exception $e) {
            return $this->sendError($e);
        }
        
        // return view('pages/front/home/index');
        
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

    public function vehicleShow($id)
    {
        try {

            $my_vehicle = [];

            $data_count = VehicleRegistration::where('id', $id)->count();

            if($data_count > 0){

                $data = VehicleRegistration::where('id', $id)->with('vehicle')->first();

                $my_vehicle = $data;

            }

            //Get Fuel Stations
            $all_fuel_stations = [];
            $fuel_stations_count = FuelStation::count();
            if($fuel_stations_count > 0){
                $get_fuel_stations = FuelStation::all();
                $all_fuel_stations = $get_fuel_stations;
            }

            return view('pages/front/vehicle/index', compact('my_vehicle', 'all_fuel_stations'));

        } catch (\Exception $e) {
            return $this->sendError($e);
        }
        
    }
}
