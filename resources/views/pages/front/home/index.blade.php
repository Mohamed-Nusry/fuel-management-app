@extends('layouts.front')


@section('content')


<div class="wrapper">
    <div class="main">
        <main class="content">
            <div class="container p-5">

                <h1 class="h1 mb-3 text-center"><strong>My Vehicles</strong> </h1>
                {{-- <br>
                <h1 class="h3 mb-3 text-center"><strong>My Vehicles</strong> </h1>
                <br> --}}
                <br>
                <hr>

                <br>
                
                <div class="row">
                 
                    @if($vehicle_registrations && $vehicle_registrations != null && count($vehicle_registrations) > 0)
                        @foreach ($vehicle_registrations as $vehicle_reg)
                            <div class="col-xl-4 col-md-4 col-sm-6 col-xxl-3 d-flex" style="padding-bottom: 15px;">
                                <a href="{{url('front/vehicle/'.$vehicle_reg->id)}}">
                                    <div class="add-div" style="background: #0b4d91">
                                        <h2 class="para-add-standard">{{$vehicle_reg->vehicle ? $vehicle_reg->vehicle->name : 'Vehicle'}}</h2>
                                       
                                        <h2 class="para-add">{{$vehicle_reg->vehicle_registration_number}}</h2>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif


                    <div class="col-xl-3 col-md-4 col-sm-6 col-xxl-3 d-flex" style="padding-bottom: 15px;">
                        <a href="{{route('front.vehicle.create')}}">
                            <div class="add-div">
                                <i class="fa fa-plus icon-add fa-5x"  aria-hidden="true"></i>
                            </div>
                        </a>
                    </div>
                  


                </div>


            </div>
        </main>
    </div>
</div>


	@endsection

	
@push('page_scripts')

	<script>
		document.addEventListener("DOMContentLoaded", function() {
	
		});
	</script>

   
@endpush
@section('page-script')