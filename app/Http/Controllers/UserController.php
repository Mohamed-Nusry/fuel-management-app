<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\FuelStation;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){}

    public function customer(Request $request){
       
        if($request->ajax()) {
            return $this->userService->get(3);
        }

        return view('pages/users/customers/index');
    }
    
    public function manager(Request $request){
       
        if($request->ajax()) {
            return $this->userService->get(2);
        }

        //Get Fuel Stations
        $all_fuel_stations = [];
        $fuel_stations_count = FuelStation::count();
        if($fuel_stations_count > 0){
            $get_fuel_stations = FuelStation::all();
            $all_fuel_stations = $get_fuel_stations;
        }

        return view('pages/users/managers/index', compact('all_fuel_stations'));
    }
    
    public function edit(Request $request){
        try {
            return $this->sendSuccess([
                'message'   => 'User has been found',
                'data'      => $this->userService->edit($request->id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }

    }

    public function create(UserRequest $request){
        try {


            $input = [];
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $input['created_by'] = Auth::user()->id;
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'User has been created',
                'data'      => $this->userService->create($input)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function update(UserUpdateRequest $request, $id){
        try {

            $input = [];
            $input = $request->all();
            $input['updated_by'] = Auth::user()->id;

            return $this->sendSuccess([
                'message'   => 'User has been updated',
                'data'      => $this->userService->update($input, $id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }

    public function delete(Request $request, $id){
        try {
            return $this->sendSuccess([
                'message'   => 'User '.$request->name.' has been deleted',
                'data'      => $this->userService->delete($id)
            ]);
        } catch (\Exception $e) {
            return $this->sendError($e);
        }
    }
}
