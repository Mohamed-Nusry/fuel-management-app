@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        
        @if(Auth::user()->user_type != null)
            @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2)
                <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New Schedule</button>
            @else
                <i class="fas fa-question-circle mt-3 btn-help" style="float:right;  cursor:pointer;"></i>
                <button disabled class="btn btn-primary mt-2 btn-create mr-2" style="float:right">Add New Schedule</button>
                
            @endif
        @endif

        <h2 style="padding:10px">Scheduled Distributions</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Schedule List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-schedule" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Fuel Station</th>
                                            <th>Scheduled Date And Time</th>
                                            <th>Quota (Liters)</th>
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
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade schedule-modal" tabindex="-1" role="dialog" aria-labelledby="schedule-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Schedule</h5>
                    <button type="button" onclick="$('.schedule-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="schedule-form" id="schedule-form">
                    <input id="schedule-id" type="hidden">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="fuel_station_id" class="col-form-label">Fuel Station</label>
                            <select id="fuel_station_id" name="fuel_station_id" class="form-control">
                                @if (count($all_fuel_stations) > 0)
                                    @foreach ($all_fuel_stations as $fuel_station)
                                        <option value="{{$fuel_station->id}}">{{$fuel_station->name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Fuel Stations</option>
                                @endif
                                
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="scheduled_date_time" class="col-form-label">Schedule Date And Time *</label>
                            <input type="datetime-local" name="scheduled_date_time" class="form-control" id="scheduled_date_time" placeholder="Date And Time">
                        </div>
                        <div class="form-group">
                            <label for="quota" class="col-form-label">Quota *</label>
                            <input type="text" name="quota" class="form-control" id="quota" placeholder="Quota">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$('.schedule-modal').modal('toggle');" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary btn-save" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

     
    <!-- Help Modal -->
    <div class="modal fade help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-exclamation-circle "></i> Access Denied</h5>
                    <button type="button" onclick="$('.help-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="help-form" id="help-form">
                    <div class="modal-body">

                        <p>If the button is disabled, that means you have no access to perform this operation. Some operations are restricted
                            to suitable roles. If you have any issues please contact Lockhood system admin.
                        </p>

                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$('.help-modal').modal('toggle');" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('page_scripts')
    @include('layouts.assets.js.datatables_js')

    <script>
        tableSchedule();
        /**
         * load table fuel station
         */
        function tableSchedule() {
            generateDataTable({
                selector: $('#table-schedule'),
                url: '{{ route('schedule.index') }}',
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
                    data: 'fuel_station_id',
                    name: 'fuel_station_id',
                },
                {
                    data: 'scheduled_date_time',
                    name: 'scheduled_date_time',
                }, 
                {
                    data: 'quota',
                    name: 'quota',
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

        $(document).ready(function() {
             /**
             * Create schedule
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("schedule-form").reset();
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Schedule`);
                $('#schedule-id').val(id);
                $('.schedule-modal').modal('toggle');
                $('#fuel_station_id').attr("disabled", false);
            });


            /**
             * edit schedule
             */
            /**
             * edit schedule
             */
             $('#table-schedule').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("schedule-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Schedule`);
                $('#schedule-id').val(id);
                const url = "schedule/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('schedule.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#schedule-id').attr("disabled", true);
                        $('#fuel_station_id').attr("disabled", true);
                        $('#scheduled_date_time').attr("disabled", true);
                        $('#quota').attr("disabled", true);
                        $('#status').attr("disabled", true);
                    },
                    complete: function () {
                        $('#schedule-id').attr("disabled", false);
                        $('#fuel_station_id').attr("disabled", true);
                        $('#scheduled_date_time').attr("disabled", false);
                        $('#quota').attr("disabled", false);
                        $('#status').attr("disabled", false);
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           if(res.data){
                            $('#schedule-id').val(res.data.id);
                            $('#fuel_station_id').val(res.data.fuel_station_id);
                            $('#scheduled_date_time').val(res.data.scheduled_date_time);
                            $('#quota').val(res.data.quota);
                            $('#status').val(res.data.status);
                           }
                        }
                    }
                });


                $('.schedule-modal').modal('toggle');
            });



            /**
             * Submit modal
             */
            $('#schedule-form').submit(function(event){
                event.preventDefault();

                const formId = $('#schedule-id').val();

                if(!formId || formId == null){

                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('schedule.create') }}',
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
                                swalSuccess('', data.nessage);
                                tableSchedule();
                                $('.schedule-modal').modal('toggle');
                            }
                        }
                    });

                }else{

                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('schedule/update') }}" + '/' + formId,
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
                            $('.btn-save').text('Successfully Updated');
                        },
                        success: function (data) {
                            if(data.status == 200) {
                                swalSuccess('', data.nessage);
                                tableSchedule();
                                $('.schedule-modal').modal('toggle');
                            }
                        }
                    });

                }

                
                return false;
            })

            /**
             * Delete schedule
             */
            $('#table-schedule').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('schedule.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete schedule?',
                    confirm: 'Delete!',
                    cancel: 'Cancel',
                    icon: 'question',
                    complete: (result) => {
                        $.ajax({
                            url: url.replace(':id', id),
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                tableSchedule();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })

            
             //On Mark as recieved button click
             $('#table-schedule').on('click', '.btn-recieved', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const status     = 2;

                changeStatus(id, name, status)
                
            })

             //On Mark as cancelled button click
             $('#table-schedule').on('click', '.btn-cancelled', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const status     = 3;

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
                            url: '{{ route('schedule.status') }}',
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(result) {
                                tableSchedule();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            }

            /**
             * Help Button
             */
             $('.btn-help').on('click', function(event) {
                event.preventDefault();
                $('.help-modal').modal('toggle');
            });
        })
    </script>
@endpush
