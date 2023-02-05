<?php

namespace App\Services;

use App\Models\FuelRequest;
use App\Repositories\FuelRequestRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FuelRequestService {

    public function __construct(
        private FuelRequestRepository $fuelrequestRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->fuelrequestRepository->getFilterQuery($data))
            ->addColumn('action', function($query){
                if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
                    $button = '<button type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }else{
                    $button = '<button disabled type="button" data-id="'.$query->id.'" class="btn btn-primary btn-sm btn-edit"><i class="fas fa-pencil-alt"></i> Edit</button> ';
                    $button .= '<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>';
                }
               
                return $button;
            })
            ->addColumn('customer_id', function (FuelRequest $customer) {
                return ($customer->customer != null) ? $customer->customer->first_name.' '.$customer->customer->last_name : "N/A";
            })
            ->addColumn('fuel_station_id', function (FuelRequest $fuelStation) {
                return ($fuelStation->fuelStation != null) ? $fuelStation->fuelStation->name : "N/A";
            })
            ->addColumn('vehicle_id', function (FuelRequest $vehicle) {
                return ($vehicle->vehicle != null) ? $vehicle->vehicle->name : "N/A";
            })
            ->addColumn('vehicle_registration_id', function (FuelRequest $vehicleRegistration) {
                return ($vehicleRegistration->vehicleRegistration != null) ? $vehicleRegistration->vehicleRegistration->reg_id : "N/A";
            })
            ->addColumn('status', function ($query) {
                if($query->status != null){
                    if($query->status ==  1){
                        return "Pending";
                    }else{
                        if($query->status ==  2){
                            return "Accepted";
                        }else{
                            if($query->status ==  3){
                                return "Rejected";
                            }else{
                                if($query->status ==  4){
                                    return "No Stock";
                                }else{
                                    if($query->status ==  5){
                                        return "Rescheduled";
                                    }else{
                                        if($query->status == 6){
                                            return "Rejected by customer";
                                        }else{
                                            if($query->status == 7){
                                                return "Completed";
                                            }else{
                                                return "N/A";
                                            }
                                        }
                                    }
                                }
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
            return $this->fuelrequestRepository->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            return $this->fuelrequestRepository->find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(array $data, $id)
    {
        try {
            return $this->fuelrequestRepository->update($data, $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            return $this->fuelrequestRepository->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
