<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Models\FuelStation;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ScheduleController extends Controller
{
    public function __construct(
        private ScheduleService $scheduleService
    ){}

    public function index(Request $request){
       
        if($request->ajax()) {
            return $this->scheduleService->get($request->all());
        }

        //Get Fuel Stations
        $all_fuel_stations = [];
        $fuel_stations_count = FuelStation::count();
        if($fuel_stations_count > 0){
            $get_fuel_stations = FuelStation::all();
            $all_fuel_stations = $get_fuel_stations;
        }

        return view('pages/schedules/index', compact('all_fuel_stations'));
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'Schedule has been found',
                'data'      => $this->scheduleService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(ScheduleRequest $request){
        try {


            $input = [];
            $input = $request->all();
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Schedule has been created',
                'data'      => $this->scheduleService->create($input)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(ScheduleUpdateRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'Schedule has been updated',
                'data'      => $this->scheduleService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'Schedule '.$request->name.' has been deleted',
                'data'      => $this->scheduleService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
