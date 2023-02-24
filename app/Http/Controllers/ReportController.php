<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ScheduleDistribution;
use App\Models\User;
use App\Models\VehicleRegistration;
use App\Services\ScheduleService;
use App\Services\UserService;
use App\Services\VehicleRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;

class ReportController extends Controller
{
    public function __construct(
        private UserService $userService,
        private ScheduleService $scheduleService,
        private VehicleRegistrationService $vehicleRegistration
    ){}

    public function customerreport(Request $request){

        if($request->ajax()) {
            return $this->userService->get(3);
        }


        return view('pages/customerreports/index');
    }

    public function vehiclereport(Request $request){

        if($request->ajax()) {
            return $this->vehicleRegistration->get($request->all());
        }


        return view('pages/vehiclereports/index');
    }

    
    public function fueldistreport(Request $request){

        if(Auth::user()->user_type == 2){
            if($request->ajax()) {
                return $this->scheduleService->getForManager();
            }
        }else{
            if($request->ajax()) {
                return $this->scheduleService->get($request->all());
            }
        }

        $total_income = 0;


        return view('pages/fueldistreports/index', compact('total_income'));

        
    }

    public function customerreportPDF(Request $request){

        $from_date = null;
        $to_date = null;

        if($request->from != null){
            $from_date = $request->from;
        }
        if($request->to != null){
            $to_date = $request->to;
        }


        if($from_date != null && $to_date != null){
            $customers = User::where('user_type', 3)->whereBetween('created_at', [$from_date, $to_date])->with('district')->get();
        }else{
            if($from_date != null && $to_date == null){
                $customers = User::where('user_type', 3)->whereDate('created_at', '>=', $from_date)->with('district')->get();
            }else{
                if($to_date != null && $from_date == null){
                    $customers = User::where('user_type', 3)->whereDate('created_at', '<=', $to_date)->with('district')->get();
                }else{
                    $customers = User::where('user_type', 3)->with('district')->get();
                }
            }
        }

  
        $data = [
            'title' => 'Customer Report',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'customers' => $customers
        ]; 
            
        $pdf = PDF::loadView('pdf/customerreport', $data);
     
        return $pdf->download('customerReport.pdf');

        // return view('pages/fueldistreports/index');

        
    }

    public function fueldistreportPDF(Request $request){

        $from_date = null;
        $to_date = null;

        if($request->from != null){
            $from_date = $request->from;
        }
        if($request->to != null){
            $to_date = $request->to;
        }


        if(Auth::user()->user_type == 2){

            if($from_date != null && $to_date != null){
                $fueldists = ScheduleDistribution::where('fuel_station_id', Auth::user()->fuel_station_id)->whereBetween('created_at', [$from_date, $to_date])->with('fuelStation')->get();
            }else{
                if($from_date != null && $to_date == null){
                    $fueldists = ScheduleDistribution::where('fuel_station_id', Auth::user()->fuel_station_id)->whereDate('created_at', '>=', $from_date)->with('fuelStation')->get();
                }else{
                    if($to_date != null && $from_date == null){
                        $fueldists = ScheduleDistribution::where('fuel_station_id', Auth::user()->fuel_station_id)->whereDate('created_at', '<=', $to_date)->with('fuelStation')->get();
                    }else{
                        $fueldists = ScheduleDistribution::where('fuel_station_id', Auth::user()->fuel_station_id)->with('fuelStation')->get();
                    }
                }
            }

        }else{
            if($from_date != null && $to_date != null){
                $fueldists = ScheduleDistribution::whereBetween('created_at', [$from_date, $to_date])->with('fuelStation')->get();
            }else{
                if($from_date != null && $to_date == null){
                    $fueldists = ScheduleDistribution::whereDate('created_at', '>=', $from_date)->with('fuelStation')->get();
                }else{
                    if($to_date != null && $from_date == null){
                        $fueldists = ScheduleDistribution::whereDate('created_at', '<=', $to_date)->with('fuelStation')->get();
                    }else{
                        $fueldists = ScheduleDistribution::with('fuelStation')->get();
                    }
                }
            }
        }
       

  
        $data = [
            'title' => 'Fuel Distribution Report',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'fueldists' => $fueldists
        ]; 
            
        $pdf = PDF::loadView('pdf/fueldistreport', $data);
     
        return $pdf->download('FuelDistributionReport.pdf');


        
    }

    public function vehiclereportPDF(Request $request){

        $from_date = null;
        $to_date = null;

        if($request->from != null){
            $from_date = $request->from;
        }
        if($request->to != null){
            $to_date = $request->to;
        }


        if($from_date != null && $to_date != null){
            $vehicles = VehicleRegistration::whereBetween('created_at', [$from_date, $to_date])->with('customer')->with('vehicle')->get();
        }else{
            if($from_date != null && $to_date == null){
                $vehicles = VehicleRegistration::whereDate('created_at', '>=', $from_date)->with('customer')->with('vehicle')->get();
            }else{
                if($to_date != null && $from_date == null){
                    $vehicles = VehicleRegistration::whereDate('created_at', '<=', $to_date)->with('customer')->with('vehicle')->get();
                }else{
                    $vehicles = VehicleRegistration::with('customer')->with('vehicle')->get();
                }
            }
        }

  
        $data = [
            'title' => 'Vehicle Report',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'vehicles' => $vehicles
        ]; 
            
        $pdf = PDF::loadView('pdf/vehiclereport', $data);
     
        return $pdf->download('VehicleReport.pdf');


        
    }
}
