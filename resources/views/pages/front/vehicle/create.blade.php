@extends('layouts.front')


@section('content')



<div class="wrapper">
    <div class="main">
        <main class="content">
            <div class="container-fluid p-5 ">
                <h1 class="login-box-msg">Vehicle Registration</h1>
                <div class="card p-2">
                    <div class="card-body ">
                      
                        <form id="vehicleregistration-form" name="vehicleregistration-form" method="post">
                            @csrf

                            <div class="input-group mb-3">
                                <select  class="form-control @error('vehicle_id') is-invalid @enderror" id="vehicle_id" name="vehicle_id" >
                                    <option value="">Select Vehicle Type</option>
                                    @if (count($all_vehicles) > 0)
                                        @foreach ($all_vehicles as $vehicle)
                                            <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                        @endforeach
            
                                    @else
                                        <option selected>No Vehicles</option>
                                    @endif
            
                                    
                                    
                                </select>
                               
            
                                @error('vehicle_id')
                                    <span class="error invalid-feedback">Vehicle Type Required.</span>
                                @enderror
                            </div>
            
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="vehicle_registration_number"
                                       class="form-control @error('vehicle_registration_number') is-invalid @enderror"
                                       value="{{ old('vehicle_registration_number') }}"
                                       placeholder="Vehicle Registration Number">
                               
                                @error('vehicle_registration_number')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <div class="input-group mb-3">
                                <input type="text"
                                       name="chassis_no"
                                       class="form-control @error('chassis_no') is-invalid @enderror"
                                       value="{{ old('chassis_no') }}"
                                       placeholder="Chassis Number">
                               
                                @error('chassis_no')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
            
                            <p>By clicking register you confirm that this vehicle belong to you and the details provided are correct.</p>
                        
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Register Vehicle</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
            
                    </div>
                    <!-- /.form-box -->
                </div><!-- /.card -->


            </div>
        </main>
    </div>
</div>


	@endsection

	
@push('page_scripts')

	<script>
		document.addEventListener("DOMContentLoaded", function() {

              /**
             * Submit modal
             */
             $('#vehicleregistration-form').submit(function(event){
                event.preventDefault();

                //Create
                const formData = new FormData(this);
                formData.append('_method', 'POST');
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('vehicleregistration.create') }}',
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
                            window.location.href = "/";
                        }
                    }
                });

                

                
                return false;
            })
	
		});
	</script>

   
@endpush
@section('page-script')