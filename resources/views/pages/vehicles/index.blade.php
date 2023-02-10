@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        
        {{-- @if(Auth::user()->user_type != null)
            @if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2)
                <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New Vehicle</button>
            @else
                <i class="fas fa-question-circle mt-3 btn-help" style="float:right;  cursor:pointer;"></i>
                <button disabled class="btn btn-primary mt-2 btn-create mr-2" style="float:right">Add New Vehicle</button>
                
            @endif
        @endif --}}
        <h2 style="padding:10px">Vehicle Management</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Vehicles List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-vehicle" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Standard Quota (Liters)</th>
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
    <div class="modal fade vehicle-modal" tabindex="-1" role="dialog" aria-labelledby="vehicle-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Vehicle</h5>
                    <button type="button" onclick="$('.vehicle-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="vehicle-form" id="vehicle-form">
                    <input id="vehicle-id" type="hidden">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="code" class="col-form-label">Code *</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="Code">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Vehicle Name *</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="standard_quota" class="col-form-label">Standard Quota *</label>
                            <input type="text" name="standard_quota" class="form-control" id="standard_quota" placeholder="Standard Quota">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$('.vehicle-modal').modal('toggle');" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        tableVehicle();
        /**
         * load table fuel station
         */
        function tableVehicle() {
            generateDataTable({
                selector: $('#table-vehicle'),
                url: '{{ route('vehicle.index') }}',
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
                    data: 'code',
                    name: 'code',
                },
                {
                    data: 'name',
                    name: 'name',
                }, 
                {
                    data: 'standard_quota',
                    name: 'standard_quota',
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
             * Create vehicle
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("vehicle-form").reset();
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Vehicle`);
                $('#vehicle-id').val(id);
                $('.vehicle-modal').modal('toggle');
            });


            /**
             * edit vehicle
             */
            /**
             * edit vehicle
             */
             $('#table-vehicle').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("vehicle-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Vehicle`);
                $('#vehicle-id').val(id);
                const url = "vehicle/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('vehicle.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#vehicle-id').attr("disabled", true);
                        $('#code').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#standard_quota').attr("disabled", true);
                    },
                    complete: function () {
                        $('#vehicle-id').attr("disabled", false);
                        $('#code').attr("disabled", false);
                        $('#name').attr("disabled", false);
                        $('#standard_quota').attr("disabled", false);
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           if(res.data){
                            $('#vehicle-id').val(res.data.id);
                            $('#code').val(res.data.code);
                            $('#name').val(res.data.name);
                            $('#standard_quota').val(res.data.standard_quota);
                           }
                        }
                    }
                });


                $('.vehicle-modal').modal('toggle');
            });



            /**
             * Submit modal
             */
            $('#vehicle-form').submit(function(event){
                event.preventDefault();

                const formId = $('#vehicle-id').val();

                if(!formId || formId == null){

                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('vehicle.create') }}',
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
                                tableVehicle();
                                $('.vehicle-modal').modal('toggle');
                            }
                        }
                    });

                }else{

                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('vehicle/update') }}" + '/' + formId,
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
                                tableVehicle();
                                $('.vehicle-modal').modal('toggle');
                            }
                        }
                    });

                }

                
                return false;
            })

            /**
             * Delete vehicle
             */
            $('#table-vehicle').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('vehicle.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete vehicle?',
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
                                tableVehicle();
                                swalSuccess('',result.message);
                            }
                        })
                    }
                })
            })

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
