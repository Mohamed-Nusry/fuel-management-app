<?php

namespace App\Services;

use App\Models\FuelToken;
use App\Repositories\FuelTokenRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FuelTokenService {

    public function __construct(
        private FuelTokenRepository $fuelrequestRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->fuelrequestRepository->getFilterQuery($data))
            ->addColumn('action', function($query){

                if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
                    if($query->status ==  1){
                        $button = '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-complete"> Complete</button>';
                        $button .= '&nbsp;<button type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-reject"> Reject</button>';
                    }else{
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-complete"> Complete</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-reject"> Reject</button>';
                    }
                }else{
                    if($query->status ==  1){
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-complete"> Complete</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-reject"> Reject</button>';
                    }else{
                        $button = '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-success btn-sm btn-complete"> Complete</button>';
                        $button .= '&nbsp;<button disabled type="button" data-id="'.$query->id.'" data-name="'.$query->name.'" class="btn btn-danger btn-sm btn-reject"> Reject</button>';
                    }
                }
               
                return $button;
            })
            ->addColumn('customer_id', function (FuelToken $customer) {
                return ($customer->customer != null) ? $customer->customer->first_name.' '.$customer->customer->last_name : "N/A";
            })
            ->addColumn('fuel_request_id', function (FuelToken $fuelRequest) {
                return ($fuelRequest->fuelRequest != null) ? $fuelRequest->fuelRequest->reference : "N/A";
            })
            ->addColumn('status', function ($query) {
                if($query->status != null){
                    if($query->status ==  1){
                        return "Pending";
                    }else{
                        if($query->status ==  2){
                            return "Collected";
                        }else{
                            if($query->status ==  3){
                                return "Rejected";
                            }else{
                                if($query->status ==  4){
                                    return "Expired";
                                }else{
                                    if($query->status ==  5){
                                        return "Completed";
                                    }else{
                                        return "N/A";
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
