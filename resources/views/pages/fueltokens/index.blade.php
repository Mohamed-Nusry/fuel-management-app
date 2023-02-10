@extends('layouts.app')

@push('page_css')
    @include('layouts.assets.css.datatables_css')
@endpush

@section('content')
    <div class="container-fluid">

        <h2 style="padding:10px">Fuel Tokens</h2>
       
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Token List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
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
                </div>
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
        tableFuelToken();
        /**
         * load table fuel tokens
         */
        function tableFuelToken() {
            generateDataTable({
                selector: $('#table-fueltoken'),
                url: '{{ route('fueltoken.index') }}',
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

        

        //On Mark as reject button click
        $('#table-fueltoken').on('click', '.btn-reject', function(event){
            event.preventDefault();
            const id       = $(this).data('id');
            const name     = $(this).data('name');
            const status     = 3;

            changeStatus(id, name, status)
            
        })
        
        //On Mark as complete button click
        $('#table-fueltoken').on('click', '.btn-complete', function(event){
          //Add with payment reference
          swalConfirm({
            title: 'Enter Payment Reference Number (Optional)',
            confirm: 'Proceed',
            cancel: 'Cancel',
            type: 'question',
            html: '<input type="text" name="payment_reference" class="form-control" id="payment_reference" placeholder="Payment Reference Number">',
            customClass: 'swal2-overflow',
            complete: (result) => {

                var paymentReference = $('#payment_reference').val();

                if(paymentReference && paymentReference != null && paymentReference != ""){

                    const formData = new FormData();
                    formData.append('id', $(this).data('id'));
                    formData.append('name', $(this).data('name'));
                    formData.append('status', 5);
                    formData.append('payment_reference', paymentReference);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    
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

                }else{
                    const formData = new FormData();
                    formData.append('id', $(this).data('id'));
                    formData.append('name', $(this).data('name'));
                    formData.append('status', 5);
                    formData.append('_method', 'POST');
                    formData.append('_token', '{{ csrf_token() }}');
                    
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
                  
                }
            })
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

        $(document).ready(function() {
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
