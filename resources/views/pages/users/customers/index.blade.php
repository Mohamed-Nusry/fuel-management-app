@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">
        
      
        <h2 style="padding:10px">Customer Management</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customers List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="table-user" class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr role="row">
                                            <th>No</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>District</th>
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
    <div class="modal fade user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pencil-alt"></i> Create Customer</h5>
                    <button type="button" onclick="$('.user-modal').modal('toggle');" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form name="user-form" id="user-form">
                    <input id="user-id" type="hidden">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="first_name" class="col-form-label">First Name *</label>
                            <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-form-label">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-form-label">Username *</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Username">
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">Email *</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="$('.user-modal').modal('toggle');" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        tableCustomer();
        /**
         * load table user
         */
        function tableCustomer() {
            generateDataTable({
                selector: $('#table-user'),
                url: '{{ route('customer.index') }}',
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
                    data: 'first_name',
                    name: 'first_name',
                }, 
                {
                    data: 'last_name',
                    name: 'last_name',
                },
                {
                    data: 'email',
                    name: 'email',
                }, 
                {
                    data: 'district_id',
                    name: 'district_id',
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
             * Create user
             */
             $('.btn-create').on('click', function(event) {
                event.preventDefault();
                document.getElementById("user-form").reset();
                const id = null;
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Create Customer`);
                $('#user-id').val(id);
                $('.user-modal').modal('toggle');
                $('#password').attr("disabled", false);
                $('#name').attr("disabled", false);
            });


            /**
             * edit user
             */
            /**
             * edit user
             */
             $('#table-user').on('click', '.btn-edit', function(event) {
                event.preventDefault();
                document.getElementById("user-form").reset();
                const id = $(this).data('id');
                $('.modal-title').html(`<i class="fas fa-pencil-alt"></i>  Edit Customer`);
                $('#user-id').val(id);
                const url = "user/edit/"+id;

                let formData = {
                    id : id,
                    _token: '{{ csrf_token() }}'
                }
            
                //Get Data
                $.ajax({
                    url: '{{ route('user.edit') }}',
                    type:'POST',
                    data: formData,
                    beforeSend: function () {
                        $('#user-id').attr("disabled", true);
                        $('#first_name').attr("disabled", true);
                        $('#last_name').attr("disabled", true);
                        $('#name').attr("disabled", true);
                        $('#email').attr("disabled", true);
                    },
                    complete: function () {
                        $('#user-id').attr("disabled", false);
                        $('#first_name').attr("disabled", false);
                        $('#last_name').attr("disabled", false);
                        $('#name').attr("disabled", true);
                        $('#email').attr("disabled", false);
                    },
                    success: function (res) {
                        if(res.status == 200) {  
                           if(res.data){
                            $('#user-id').val(res.data.id);
                            $('#first_name').val(res.data.first_name);
                            $('#last_name').val(res.data.last_name);
                            $('#name').val(res.data.name);
                            $('#email').val(res.data.email);
                           }
                        }
                    }
                });


                $('.user-modal').modal('toggle');
            });



            /**
             * Submit modal
             */
            $('#user-form').submit(function(event){
                event.preventDefault();

                const formId = $('#user-id').val();

                if(!formId || formId == null){

                    //Create Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('user_type', 3);
                    $.ajax({
                        url: '{{ route('user.create') }}',
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
                                tableCustomer();
                                $('.user-modal').modal('toggle');
                            }
                        }
                    });

                }else{

                    //Update Mode
                    const formData = new FormData(this);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');
                    $.ajax({
                        url:"{{ url('user/update') }}" + '/' + formId,
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
                                tableCustomer();
                                $('.user-modal').modal('toggle');
                            }
                        }
                    });

                }

                
                return false;
            })

            /**
             * Delete user
             */
            $('#table-user').on('click', '.btn-delete', function(event){
                event.preventDefault();
                const id       = $(this).data('id');
                const name     = $(this).data('name');
                const formData = new FormData();
                const url      = "{{ route('user.delete', ['id' => ':id']) }}";
                formData.append('id', id);
                formData.append('name', name);
                formData.append('_method', 'DELETE');
                formData.append('_token', '{{ csrf_token() }}');
                swalConfirm({
                    title: 'Delete user?',
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
                                tableCustomer();
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
