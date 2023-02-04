@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        
        <h2 style="padding:10px">Vehicle Registration Management</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Vehicle Registrations List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-vehicleregistration" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Customer</th>
                                            <th>Vehicle</th>
                                            <th>Email</th>
                                            <th>Vehicle Registration</th>
                                            <th>Chasis No</th>
                                            <th>Total Quota (Liters)</th>
                                            <th>Available Quota (Liters)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

@endsection

@push('page_scripts')
    @include('layouts.assets.js.datatables_js')

    <script>
        tableVehicleRegistration();
        /**
         * load table fuel station
         */
        function tableVehicleRegistration() {
            generateDataTable({
                selector: $('#table-vehicleregistration'),
                url: '{{ route('vehicleregistration.index') }}',
                columns: [{
                    data: null,
                    sortable: false,
                    width: '10%',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },  
                {
                    data: 'customer_id',
                    name: 'customer_id',
                },
                {
                    data: 'vehicle_id',
                    name: 'vehicle_id',
                }, 
                {
                    data: 'email',
                    name: 'email',
                }, 
                {
                    data: 'vehicle_registration_number',
                    name: 'vehicle_registration_number',
                }, 
                {
                    data: 'chassis_no',
                    name: 'chassis_no',
                }, 
                {
                    data: 'total_quota',
                    name: 'total_quota',
                }, 
                {
                    data: 'available_quota',
                    name: 'available_quota',
                }
                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3]
                }, ],
            });
        }

    </script>
@endpush
