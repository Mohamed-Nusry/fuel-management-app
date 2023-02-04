<?php

namespace App\Services;

use App\Models\VehicleRegistration;
use App\Repositories\VehicleRegistrationRepository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class VehicleRegistrationService {

    public function __construct(
        private VehicleRegistrationRepository $vehicleRepository
    ){}

    public function get(array $data)
    {
        return DataTables::eloquent($this->vehicleRepository->getFilterQuery($data))
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
