<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelRequestRequest;
use App\Http\Requests\FuelRequestUpdateRequest;
use App\Models\FuelRequest;
use App\Models\FuelStation;
use App\Models\FuelToken;
use App\Models\VehicleRegistration;
use App\Services\FuelRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FuelRequestController extends Controller
{
    public function __construct(
        private FuelRequestService $fuelrequestService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->fuelrequestService->get($request->all());
        }

        return view('pages/fuelrequests/index');
    }

    public function byCustomer(Request $request){
       
        if($request->ajax()) {
            return $this->fuelrequestService->customer($request->all());
        }

        return view('pages/fuelrequests/index');
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Request has been found',
                'data'      => $this->fuelrequestService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(FuelRequestRequest $request){
        try {


            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;
            $input['customer_id'] = Auth::user()->id;

                
            $create_fuel_request = $this->fuelrequestService->create($input);

            if($create_fuel_request){
                //Add Reference No
                $update_vehicle_reg = FuelRequest::where('id', $create_fuel_request->id)->first();
                $update_vehicle_reg->reference = 'REF00'.$create_fuel_request->id;
                $update_vehicle_reg->save();
            }

            return $this->sendSuccess([
                'message'   => 'Fuel Request has been created',
                'data'      => $create_fuel_request
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(FuelRequestUpdateRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Fuel Request has been updated',
                'data'      => $this->fuelrequestService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Request '.$request->name.' has been deleted',
                'data'      => $this->fuelrequestService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function changeStatus(Request $request){

      
           
        // $details = [
        //     'reference' => 'REF0010',
        //     'customer_name' => 'Admin',
        //     'vehicle_registration' => 'VMA-0001',
        //     'chasis_no' => 'ABB-O001-001',
        //     'fuel_station' => 'Colombo',
        //     'requested_quota' => '5',
        //     'expected_date_time' => '2023/03/25',
        //     'recheduled_date_time' => null
        // ];
        
        // Mail::to('john@gmail.com')->send(new \App\Mail\ConfirmationMail($details));
        
        // dd("Email is Sent.");
        

        try {
            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            $update_status = $this->fuelrequestService->update($input, $request->id);

            if($update_status && ($request->status == 2 || $request->status == 5)){
                //Get Request Details
                $get_req_details = FuelRequest::where('id', $request->id)->first();

                //Create Token
                $create_token = new FuelToken();
                $create_token->customer_id = $get_req_details->customer_id;
                $create_token->fuel_request_id = $request->id;
                $create_token->created_by = Auth::user()->id;
                $create_token->updated_by = Auth::user()->id;
                $create_token->save();

                if($create_token){
                    //Update Ref No
                    $get_token_details = FuelToken::where('id', $create_token->id)->first();
                    $get_token_details->token_ref = 'REF00'.$create_token->id;
                    $get_token_details->save();

                    //Reduce Fuel From Customer
                    $get_vehicle_registration_count = VehicleRegistration::where('id', $get_req_details->vehicle_registration_id)->count();

                    if($get_vehicle_registration_count > 0){
                        $get_vehicle_registration = VehicleRegistration::where('id', $get_req_details->vehicle_registration_id)->first();
                        $get_vehicle_registration->available_quota = $get_vehicle_registration->available_quota - $get_req_details->requested_quota;
                        $get_vehicle_registration->save();
                    }

                     //Reduce Fuel From Station
                     $get_fuel_station_count = FuelStation::where('id', $get_req_details->fuel_station_id)->count();

                     if($get_fuel_station_count > 0){
                         $get_fuel_station = FuelStation::where('id', $get_req_details->fuel_station_id)->first();
                         $get_fuel_station->available_quota = $get_fuel_station->available_quota - $get_req_details->requested_quota;
                         $get_fuel_station->save();
                     }



                }

                //Send Confirmation Email

            }
           
            if($request->status == 2 || $request->status == 5){
                return $this->sendSuccess([
                    'message'   => 'Status has been updated and token issued',
                    'data'      => null
                ]);
            }else{
                return $this->sendSuccess([
                    'message'   => 'Status has been updated',
                    'data'      => null
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
