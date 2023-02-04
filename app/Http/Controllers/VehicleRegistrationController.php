<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRegistrationRequest;
use App\Http\Requests\VehicleRegistrationUpdateRequest;
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

    public function create(VehicleRegistrationRequest $request){
        try {


            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Vehicle Registration has been created',
                'data'      => $this->vehicleService->create($input)
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
