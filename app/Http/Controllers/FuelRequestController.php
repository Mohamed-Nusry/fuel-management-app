<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelRequestRequest;
use App\Http\Requests\FuelRequestUpdateRequest;
use App\Models\FuelStation;
use App\Services\FuelRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'FuelRequest has been found',
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

            return $this->sendSuccess([
                'message'   => 'FuelRequest has been created',
                'data'      => $this->fuelrequestService->create($input)
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
                'message'   => 'FuelRequest has been updated',
                'data'      => $this->fuelrequestService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'FuelRequest '.$request->name.' has been deleted',
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
                //Create Token
                
            }
           
            return $this->sendSuccess([
                'message'   => 'Status has been updated and token issued',
                'data'      => null
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
