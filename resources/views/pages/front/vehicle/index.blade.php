@extends('layouts.front')


@section('content')

@if ($my_vehicle && $my_vehicle != null)


<div class="wrapper">
    <div class="main">
        <main class="content">
            <div class="container p-5 ">

                <h1 class="h1 mb-3 text-center"><strong>{{$my_vehicle->vehicle ? $my_vehicle->vehicle->name : "Vehicle"}} - {{$my_vehicle->vehicle_registration_number}}</strong> </h1>
                <br>
                <br>
                <div class="row ">
                    <div class="col-xl-3 col-xxl-5 d-flex">
                        <p class="text-bold">Vehicle Registration No = {{$my_vehicle->vehicle_registration_number}}</p>
                    </div>
                    <div class="col-xl-3 col-xxl-5 d-flex">
                        <p class="text-bold">Vehicle Chassis No = {{$my_vehicle->chassis_no}}</p>
                    </div>
                    <div class="col-xl-3 col-xxl-5 d-flex">
                        <p class="text-bold">Total Weekly Quota = {{$my_vehicle->vehicle ? $my_vehicle->vehicle->standard_quota : "0"}} liters</p>
                    </div>
                    <div class="col-xl-3 col-xxl-5 d-flex">
                        <p class="text-bold">Remaining Quota = {{$my_vehicle->available_quota}} liters</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-xxl-5 d-flex">
                        @php
                            $standard_quota = $my_vehicle->vehicle ? $my_vehicle->vehicle->standard_quota : 0;
                            $remaining_quota = $my_vehicle->available_quota;
                            $percentage = ($remaining_quota * 100) / $standard_quota;
                        @endphp
                        <progress class="custom-progress-bar" id="file" value="{{$percentage}}" max="100"> {{$percentage}}% </progress>
                    </div>
                </div>
                <br>
                <hr>
                <br>

                <div class="row ">
                    <div class="col-xl-12 col-xxl-5">
                        <h3 class="text-center text-bold">Request Fuel</h3>
                    </div>

                    <br>
                    <br>
                    <br>

                    <div class="col-xl-12 col-xxl-5">
                        <form id="fuelrequest-form" name="fuelrequest-form" method="post" action="{{ route('fuelrequest.create') }}">
                            @csrf

                            <input type="hidden" name="vehicle_registration_id" id="vehicle_registration_id" value="{{$my_vehicle->id}}">
                            <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$my_vehicle->vehicle ? $my_vehicle->vehicle->id : null}}">

                            <div class="form-group">
                                <select id="fuel_station_id" name="fuel_station_id" class="form-control @error('fuel_station_id') is-invalid @enderror">
                                    <option value="">Select Fuel Station</option>
                                    @if (count($all_fuel_stations) > 0)
                                        @foreach ($all_fuel_stations as $fuel_station)
                                            <option value="{{$fuel_station->id}}">{{$fuel_station->name}}</option>
                                        @endforeach
    
                                    @else
                                        <option selected>No Fuel Stations</option>
                                    @endif
                                    
                                </select>

                                @error('fuel_station_id')
                                    <span class="error invalid-feedback">Fuel Station Required.</span>
                                @enderror
                            </div>

            
                            <div class="input-group mb-3">
                                <input type="number"
                                       id="requested_quota"
                                       name="requested_quota"
                                       class="form-control @error('requested_quota') is-invalid @enderror"
                                       value="{{ old('requested_quota') }}"
                                       placeholder="Require Quota (Liters)">
                               
                                @error('requested_quota')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="input-group mb-3">
                                <input type="text"
                                       id="datetimefield"
                                       name="expected_date_time"
                                       class="form-control @error('expected_date_time') is-invalid @enderror"
                                       value="{{ old('expected_date_time') }}"
                                       placeholder="Expected Date And Time">
                               
                                @error('expected_date_time')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <p>After clicking request, fuel station will review your request and update you. And note that you have to wait 3 hours from your expected date and time to request again if not accepted.</p>
                        
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Request</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>


                </div>


                <br>
                <hr>
                <br>

                <div class="row ">
                    <div class="col-xl-12 col-xxl-5">
                        <h3 class="text-center text-bold">Fuel Request Status</h3>
                    </div>


                    <div class="col-xl-12 col-xxl-5">
                        <table id="table-fuelrequest" class="table table-bordered">
                            <thead class="thead-dark">
                                <tr role="row">
                                    <th>No</th>
                                    <th>Ref</th>
                                    <th>Fuel Station</th>
                                    <th>Requested Quota (Liters)</th>
                                    <th>Expected Date And Time</th>
                                    <th>Rescheduled Date And Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                </div>

                <br>
                <hr>
                <br>


                <div class="row ">
                    <div class="col-xl-12 col-xxl-5">
                        <h3 class="text-center text-bold">Token</h3>
                    </div>


                    <div class="col-xl-12 col-xxl-5">
                        <table id="table-fueltoken" class="table table-bordered">
                            <thead class="thead-dark">
                                <tr role="row">
                                    <th>No</th>
                                    <th>Token Ref</th>
                                    <th>Customer</th>
                                    <th>Fuel Request Ref</th>
                                    <th>Payment Reference</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                </div>
                


            </div>
        </main>
    </div>
</div>

    
@else
    <h2 class="text-center p-5 text-bold">Your vehicle not found</h2>
@endif


	@endsection

	
@push('page_scripts')
@include('layouts.assets.js.datatables_js')

	<script>

        $(document).ready(function(){
            $("#datetimefield").focus( function() {
                $(this).attr({type: 'datetime-local'});
            });
        });

        tableFuelRequest();
        tableFuelToken();
        
        /**
         * load table fuel request
         */
        function tableFuelRequest() {
            generateDataTable({
                searching: false,
                paging: false, 
                info: false,
                bFilter: false, 
                bInfo: false,
                selector: $('#table-fuelrequest'),
                url: '{{ route('fuelrequest.customer') }}',
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
                    data: 'reference',
                    name: 'reference',
                },
                {
                    data: 'fuel_station_id',
                    name: 'fuel_station_id',
                },
                {
                    data: 'requested_quota',
                    name: 'requested_quota',
                }, 
                {
                    data: 'expected_date_time',
                    name: 'expected_date_time',
                }, 
                {
                    data: 'rescheduled_date_time',
                    name: 'rescheduled_date_time',
                }, 
                {
                    data: 'status',
                    name: 'status',
                }, 
                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3]
                }, ],
            });
        }

        /**
         * load table fuel tokens
         */
         function tableFuelToken() {
            generateDataTable({
                searching: false,
                paging: false, 
                info: false,
                bFilter: false, 
                bInfo: false,
                selector: $('#table-fueltoken'),
                url: '{{ route('fueltoken.customer') }}',
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
                    data: 'token_ref',
                    name: 'token_ref',
                },
                {
                    data: 'customer_id',
                    name: 'customer_id',
                },
                {
                    data: 'fuel_request_id',
                    name: 'fuel_request_id',
                },
                {
                    data: 'payment_reference',
                    name: 'payment_reference',
                }, 
                {
                    data: 'status',
                    name: 'status',
                }, 
                {
                    data: 'action',
                    name: 'action',
                    width: '20%',
                }
                ],
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3]
                }, ],
            });
        }


		document.addEventListener("DOMContentLoaded", function() {

            /**
             * Submit modal
            */
            $('#fuelrequest-form').submit(function(event){
                event.preventDefault();

                var remainingQuota = {!! addcslashes($my_vehicle->available_quota, '"') !!}
             
                var requestedQuota = $('#requested_quota').val();

                // console.log(remainingQuota);
               

                if(remainingQuota && requestedQuota){
                    if(requestedQuota > remainingQuota){
                        swalError('', 'Cannot request quota more than remaining amount');
                    }else{

                        //Create
                        const formData = new FormData(this);
                        formData.append('_method', 'POST');
                        formData.append('_token', '{{ csrf_token() }}');
                        $.ajax({
                            url: '{{ route('fuelrequest.create') }}',
                            data: formData,
                            type:'POST',
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $('.btn-save').attr("disabled", true);
                                $('.btn-save').text('Please wait......');
                            },
                            complete: function () {
                                $('.btn-save').attr("disabled", false);
                                $('.btn-save').text('Successfully Created');
                            },
                            success: function (data) {
                                if(data.status == 200) {  
                                    tableFuelRequest();
                                    tableFuelToken();
                                    swalSuccess('', data.nessage);
                                    //window.location.href = "/";
                                }
                            }
                        });


                    }
                }else{
                    swalError('', 'Please Fill All The Fields');
                }

                
                

                
                return false;
            })


             //On Mark as collect button click
            $('#table-fueltoken').on('click', '.btn-collect', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const status     = 2;

                changeStatus(id, name, status)
                
            })

            //Change Status
            function changeStatus(id, name, status){
                const formData = new FormData();
                formData.append('id', id);
                formData.append('name', name);
                formData.append('status', status);
                formData.append('_method', 'POST');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Change Status?',
                    confirm: 'Proceed',
                    cancel: 'Cancel',
                    icon: 'question',
                    complete: (result) => {
                        $.ajax({
                            url: '{{ route('fueltoken.status') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                tableFuelToken();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            }
            
	
		});
	</script>

   
@endpush
@section('page-script')