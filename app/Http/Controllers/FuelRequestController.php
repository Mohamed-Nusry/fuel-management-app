<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelRequestRequest;
use App\Http\Requests\FuelRequestUpdateRequest;
use App\Models\FuelRequest;
use App\Models\FuelStation;
use App\Models\FuelToken;
use App\Models\User;
use App\Models\VehicleRegistration;
use App\Services\FuelRequestService;
use Carbon\Carbon;
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

        if(Auth::user()->user_type == 2){
            if($request->ajax()) {
                return $this->fuelrequestService->getForManager();
            }
        }else{
            if($request->ajax()) {
                return $this->fuelrequestService->get($request->all());
            }
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

    public function check(FuelRequestRequest $request){
        try {

            $check_already_req_count = FuelRequest::where('customer_id', Auth::user()->id)->where('vehicle_registration_id', $request->vehicle_registration_id)->count();
            if($check_already_req_count > 0){
                $check_already_req = FuelRequest::where('customer_id', Auth::user()->id)->where('vehicle_registration_id', $request->vehicle_registration_id)->get();

                foreach ($check_already_req as $key => $already_req) {
                    if($already_req->status != 3 && $already_req->status != 6 && $already_req->status != 7){
                        return $this->sendCustomError("You have already requested fuel. Please wait for 3 hours before request again");
                    }
                }

                return $this->sendSuccess([
                    'message'   => 'Able to request',
                    'data'      => []
                ]);
            }
       

            return $this->sendSuccess([
                'message'   => 'Able to request',
                'data'      => []
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
                    $vehicle_registration_no = null;
                    $chasis_no = null;
                    $get_vehicle_registration_count = VehicleRegistration::where('id', $get_req_details->vehicle_registration_id)->count();

                    if($get_vehicle_registration_count > 0){
                        $get_vehicle_registration = VehicleRegistration::where('id', $get_req_details->vehicle_registration_id)->first();
                        $get_vehicle_registration->available_quota = $get_vehicle_registration->available_quota - $get_req_details->requested_quota;
                        $get_vehicle_registration->save();

                        $vehicle_registration_no = $get_vehicle_registration->vehicle_registration_number;
                        $chasis_no = $get_vehicle_registration->chassis_no;
                    }

                     //Reduce Fuel From Station
                     $fuel_station_name = null;
                     $get_fuel_station_count = FuelStation::where('id', $get_req_details->fuel_station_id)->count();

                     if($get_fuel_station_count > 0){
                         $get_fuel_station = FuelStation::where('id', $get_req_details->fuel_station_id)->first();
                         $get_fuel_station->available_quota = $get_fuel_station->available_quota - $get_req_details->requested_quota;
                         $get_fuel_station->save();

                         $fuel_station_name = $get_fuel_station->name;
                     }



                }

              
                //Get Customer Data
                $customer_name = null;
                $customer_email = "headoffice@gmail.com";
                $customer_data_count = User::where('id', $get_req_details->customer_id)->count();

                if($customer_data_count > 0){
                    $customer_data = User::where('id', $get_req_details->customer_id)->first();
                    $customer_name = $customer_data->first_name.' '.$customer_data->last_name;
                    $customer_email = $customer_data->email;
                }


                $details = [
                    'reference' => $get_req_details->reference,
                    'customer_name' => $customer_name,
                    'vehicle_registration' => $vehicle_registration_no != null ? $vehicle_registration_no : 'N/A',
                    'chasis_no' => $chasis_no != null ? $chasis_no : 'N/A',
                    'fuel_station' => $fuel_station_name != null ? $fuel_station_name : 'N/A',
                    'requested_quota' => $get_req_details->requested_quota,
                    'expected_date_time' => $get_req_details->expected_date_time,
                    'recheduled_date_time' => $get_req_details->rescheduled_date_time != null ? $get_req_details->rescheduled_date_time : null
                ];
                
                if($request->status == 2){
                    //Send Confirmation Email
                    Mail::to($customer_email)->send(new \App\Mail\ConfirmationMail($details));
                }else{
                    if($request->status == 5){
                        //Send Recheduled Email
                        Mail::to($customer_email)->send(new \App\Mail\ReschduleMail($details));
                    }
                }
              

            }else{
                //Request Rejection
                if($update_status && $request->status == 3){

                    //Get Request Details
                    $get_req_details = FuelRequest::where('id', $request->id)->first();

                    //Get Customer Data
                    $customer_name = null;
                    $customer_email = "headoffice@gmail.com";
                    $customer_data_count = User::where('id', $get_req_details->customer_id)->count();

                    if($customer_data_count > 0){
                        $customer_data = User::where('id', $get_req_details->customer_id)->first();
                        $customer_name = $customer_data->first_name.' '.$customer_data->last_name;
                        $customer_email = $customer_data->email;
                    }

                    $vehicle_registration_no = null;
                    $chasis_no = null;
                    $get_vehicle_registration_count = VehicleRegistration::where('id', $get_req_details->vehicle_registration_id)->count();

                    if($get_vehicle_registration_count > 0){
                        $get_vehicle_registration = VehicleRegistration::where('id', $get_req_details->vehicle_registration_id)->first();
                        $vehicle_registration_no = $get_vehicle_registration->vehicle_registration_number;
                        $chasis_no = $get_vehicle_registration->chassis_no;
                    }

                    $fuel_station_name = null;
                    $get_fuel_station_count = FuelStation::where('id', $get_req_details->fuel_station_id)->count();

                    if($get_fuel_station_count > 0){
                        $get_fuel_station = FuelStation::where('id', $get_req_details->fuel_station_id)->first();
                        $fuel_station_name = $get_fuel_station->name;
                    }

                    $details = [
                        'reference' => $get_req_details->reference,
                        'customer_name' => $customer_name,
                        'vehicle_registration' => $vehicle_registration_no != null ? $vehicle_registration_no : 'N/A',
                        'chasis_no' => $chasis_no != null ? $chasis_no : 'N/A',
                        'fuel_station' => $fuel_station_name != null ? $fuel_station_name : 'N/A',
                        'requested_quota' => $get_req_details->requested_quota,
                        'expected_date_time' => $get_req_details->expected_date_time,
                        'recheduled_date_time' => $get_req_details->rescheduled_date_time != null ? $get_req_details->rescheduled_date_time : null
                    ];
                    
                    //Send Rejection Email
                    Mail::to($customer_email)->send(new \App\Mail\RejectedMail($details));
                }
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
