<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelStationRequest;
use App\Http\Requests\FuelStationUpdateRequest;
use App\Models\District;
use App\Services\FuelStationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FuelStationController extends Controller
{
    public function __construct(
        private FuelStationService $fuelstationService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->fuelstationService->get($request->all());
        }

        //Get Districts
        $all_districts = [];
        $districts_count = District::count();
        if($districts_count > 0){
            $get_districts = District::all();
            $all_districts = $get_districts;
        }

        return view('pages/fuelstations/index', compact('all_districts'));
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Station has been found',
                'data'      => $this->fuelstationService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(FuelStationRequest $request){
        try {


            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Fuel Station has been created',
                'data'      => $this->fuelstationService->create($input)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(FuelStationUpdateRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Fuel Station has been updated',
                'data'      => $this->fuelstationService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Fuel Station '.$request->name.' has been deleted',
                'data'      => $this->fuelstationService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
