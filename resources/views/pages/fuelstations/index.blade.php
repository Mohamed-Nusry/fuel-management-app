@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        
        @if(Auth::user()->user_type != null)
            @if(Auth::user()->user_type == 1)
                <button class="btn btn-primary mt-2 btn-create" style="float:right">Add New Fuel Station</button>
            @else
                <i class="fas fa-question-circle mt-3 btn-help" style="float:right;  cursor:pointer;"></i>
                <button disabled class="btn btn-primary mt-2 btn-create mr-2" style="float:right">Add New Fuel Station</button>
                
            @endif
        @endif
        <h2 style="padding:10px">Fuel Station Management</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Fuel Stations List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-fuelstation" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>District</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Available Quota</th>
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
    <div class="modal fade fuelstation-modal" tabindex="-1" role="dialog" aria-labelledby="fuelstation-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Fuel Station</h5>
                    <button type="button" onclick="$('.fuelstation-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="fuelstation-form" id="fuelstation-form">
                    <input id="fuelstation-id" type="hidden">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="district_id" class="col-form-label">District</label>
                            <select id="district_id" name="district_id" class="form-control">
                                @if (count($all_districts) > 0)
                                    @foreach ($all_districts as $district)
                                        <option value="{{$district->id}}">{{$district->name}}</option>
                                    @endforeach

                                @else
                                    <option selected>No Districts</option>
                                @endif
                                
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="code" class="col-form-label">Code *</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="Code">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Fuel Station Name *</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="available_quota" class="col-form-label">Available Quota *</label>
                            <input type="text" name="available_quota" class="form-control" id="available_quota" placeholder="Available Quota">
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-form-label">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="1">Available</option>
                                <option value="2">Unvailable</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$('.fuelstation-modal').modal('toggle');" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                            to suitable roles. If you have any issues please contact FuelIn system admin.
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
        tableFuelStation();
        /**
         * load table fuel station
         */
        function tableFuelStation() {
            generateDataTable({
                selector: $('#table-fuelstation'),
                url: '{{ route('fuelstation.index') }}',
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
                    data: 'district_id',
                    name: 'district_id',
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
                    data: 'available_quota',
                    name: 'available_quota',
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
             * Create fuelstation
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("fuelstation-form").reset();
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Fuel Station`);
                $('#fuelstation-id').val(id);
                $('.fuelstation-modal').modal('toggle');
                $('#status').attr("disabled", false);
                $('#district_id').attr("disabled", false);
            });


            /**
             * edit fuelstation
             */
            /**
             * edit fuelstation
             */
             $('#table-fuelstation').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("fuelstation-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit FuelStation`);
                $('#fuelstation-id').val(id);
                const url = "fuelstation/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('fuelstation.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#fuelstation-id').attr("disabled", true);
                        $('#code').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#available_quota').attr("disabled", true);
                        $('#status').attr("disabled", true);
                        $('#district_id').attr("disabled", true);
                    },
                    complete: function () {
                        $('#fuelstation-id').attr("disabled", false);
                        $('#code').attr("disabled", false);
                        $('#name').attr("disabled", false);
                        $('#available_quota').attr("disabled", false);
                        $('#status').attr("disabled", true);
                        $('#district_id').attr("disabled", true);
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           if(res.data){
                            $('#fuelstation-id').val(res.data.id);
                            $('#code').val(res.data.code);
                            $('#name').val(res.data.name);
                            $('#available_quota').val(res.data.available_quota);
                            $('#status').val(res.data.status);
                            $('#district_id').val(res.data.district_id);
                           }
                        }
                    }
                });


                $('.fuelstation-modal').modal('toggle');
            });



            /**
             * Submit modal
             */
            $('#fuelstation-form').submit(function(event){
                event.preventDefault();

                const formId = $('#fuelstation-id').val();

                if(!formId || formId == null){

                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url: '{{ route('fuelstation.create') }}',
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
                                tableFuelStation();
                                $('.fuelstation-modal').modal('toggle');
                            }
                        }
                    });

                }else{

                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('fuelstation/update') }}" + '/' + formId,
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
                                tableFuelStation();
                                $('.fuelstation-modal').modal('toggle');
                            }
                        }
                    });

                }

                
                return false;
            })

            /**
             * Delete fuelstation
             */
            $('#table-fuelstation').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('fuelstation.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete fuelstation?',
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
                                tableFuelStation();
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
