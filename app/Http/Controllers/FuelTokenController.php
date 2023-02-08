<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelTokenRequest;
use App\Http\Requests\FuelTokenUpdateRequest;
use App\Models\FuelRequest;
use App\Models\FuelToken;
use App\Models\FuelStation;
use App\Models\VehicleRegistration;
use App\Services\FuelTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FuelTokenController extends Controller
{
    public function __construct(
        private FuelTokenService $fueltokenService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->fueltokenService->get($request->all());
        }

        return view('pages/fueltokens/index');
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Token has been found',
                'data'      => $this->fueltokenService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(FuelTokenRequest $request){
        try {


            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Fuel Token has been created',
                'data'      => $this->fueltokenService->create($input)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(FuelTokenUpdateRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Fuel Token has been updated',
                'data'      => $this->fueltokenService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Token '.$request->name.' has been deleted',
                'data'      => $this->fueltokenService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function changeStatus(Request $request){

        try {
            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            $update_status = $this->fueltokenService->update($input, $request->id);

            if($update_status && ($request->status == 3 || $request->status == 4)){
                //Add Fuel back to station on reject or expire

                //Get Token Details
                $get_token_details = FuelToken::where('id', $request->id)->first();
              
                //Get Token Details
                $get_request_details_count = FuelRequest::where('id', $get_token_details->fuel_request_id)->count();
                if($get_request_details_count > 0){
                    $get_request_details = FuelRequest::where('id', $get_token_details->fuel_request_id)->first();
                    $requested_quota = $get_request_details->requested_quota;

                    //Add Fuel To Station
                    $get_station_details_count = FuelStation::where('id', $get_request_details->fuel_station_id)->count();

                    if($get_station_details_count > 0){
                       
                        $get_station_details = FuelStation::where('id', $get_request_details->fuel_station_id)->first();
                        $get_station_details->available_quota =  $get_station_details->available_quota + $requested_quota;
                        $get_station_details->save();
    
                    }
                    

                }
                
            }
           
   
            return $this->sendSuccess([
                'message'   => 'Status has been updated',
                'data'      => null
            ]);
            
            
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
