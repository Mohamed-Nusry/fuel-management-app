<?php

namespace App\Services;

use App\Models\ScheduleDistribution;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ScheduleService {

    public function __construct(
        private ScheduleRepository $vehicleRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->vehicleRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
                    if($query->status ==  1){
                        $button = '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }else{
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }
                }else{
                    if($query->status ==  1){
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }else{
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }
                }
               
                return $button;
            })
            ->addColumn('fuel_station_id', function (ScheduleDistribution $fuelStation) {
                return ($fuelStation->fuelStation != null) ? $fuelStation->fuelStation->name : "N/A";
            })
            ->addColumn('status', function ($query) {
                if($query->status != null){
                    if($query->status ==  1){
                        return "Pending";
                    }else{
                        if($query->status ==  2){
                            return "Recieved";
                        }else{
                            if($query->status ==  3){
                                return "Not Recieved";
                            }else{
                                return "N/A";
                            }
                        }
                    }
                }else{
                    return "N/A";
                }
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getForManager()
    {
        $custom_data = ScheduleDistribution::where('fuel_station_id', Auth::user()->fuel_station_id);
        return DataTables::of($custom_data)
            ->addColumn('action', function($query){
                if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
                    if($query->status ==  1){
                        $button = '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }else{
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }
                }else{
                    if($query->status ==  1){
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }else{
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-recieved"> Recieved</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-cancelled"> Not Recieved</button>';
                    }
                }
               
                return $button;
            })
            ->addColumn('fuel_station_id', function (ScheduleDistribution $fuelStation) {
                return ($fuelStation->fuelStation != null) ? $fuelStation->fuelStation->name : "N/A";
            })
            ->addColumn('status', function ($query) {
                if($query->status != null){
                    if($query->status ==  1){
                        return "Pending";
                    }else{
                        if($query->status ==  2){
                            return "Recieved";
                        }else{
                            if($query->status ==  3){
                                return "Not Recieved";
                            }else{
                                return "N/A";
                            }
                        }
                    }
                }else{
                    return "N/A";
                }
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function create(array $data)
    {
        try {
            return $this->vehicleRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->vehicleRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->vehicleRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->vehicleRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
