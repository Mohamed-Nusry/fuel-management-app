<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelTokenRequest;
use App\Http\Requests\FuelTokenUpdateRequest;
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
        private FuelTokenService $fuelrequestService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->fuelrequestService->get($request->all());
        }

        return view('pages/fueltokens/index');
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Token has been found',
                'data'      => $this->fuelrequestService->edit($request->id)
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
                'data'      => $this->fuelrequestService->create($input)
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
                'data'      => $this->fuelrequestService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Token '.$request->name.' has been deleted',
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

            if($update_status && ($request->status == 3 || $request->status == 4)){
                //Add Fuel back to station on reject or expire

                
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
