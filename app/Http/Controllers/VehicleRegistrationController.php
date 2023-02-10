<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRegistrationRequest;
use App\Http\Requests\VehicleRegistrationUpdateRequest;
use App\Models\Vehicle;
use App\Models\VehicleRegistration;
use App\Services\VehicleRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VehicleRegistrationController extends Controller
{
    public function __construct(
        private VehicleRegistrationService $vehicleService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->vehicleService->get($request->all());
        }

        return view('pages/vehicleregistrations/index');
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Vehicle Registration has been found',
                'data'      => $this->vehicleService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(Request $request){

        $this->validate($request,[
            'vehicle_id'=>'required',
            'vehicle_registration_number' => ['required','unique:vehicle_registrations'],
            'chassis_no' => ['required','unique:vehicle_registrations'],
        ]);


        try {


            $input = [];
            $input = $request->all();
            $input['customer_id'] = Auth::user()->id;
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;
            
            $create_vehicle_reg = $this->vehicleService->create($input);

            if($create_vehicle_reg){
                //Get Fuel Quota For Vehicle
                $standard_quota = 0;
                $get_fuel_cap_count = Vehicle::where('id', $create_vehicle_reg->vehicle_id)->count();
                if($get_fuel_cap_count > 0){
                    $get_fuel_cap = Vehicle::where('id', $create_vehicle_reg->vehicle_id)->first();
                    $standard_quota = $get_fuel_cap->standard_quota;
                }

                //Add Registration No
                $update_vehicle_reg = VehicleRegistration::where('id', $create_vehicle_reg->id)->first();
                $update_vehicle_reg->reg_id = 'REG00'.$create_vehicle_reg->id;
                $update_vehicle_reg->total_quota = $standard_quota;
                $update_vehicle_reg->available_quota = $standard_quota;
                $update_vehicle_reg->save();
            }

            return $this->sendSuccess([
                'message'   => 'Vehicle Registration has been created',
                'data'      => $create_vehicle_reg
            ]);

        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(VehicleRegistrationUpdateRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Vehicle Registration has been updated',
                'data'      => $this->vehicleService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Vehicle Registration '.$request->name.' has been deleted',
                'data'      => $this->vehicleService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
