@extends('layouts.front')


@section('content')


<div class="wrapper">
    <div class="main">
        <main class="content">
            <div class="container-fluid p-5">

                <h1 class="h1 mb-3 text-center"><strong>Welcome</strong> </h1>
                <br>
                <h1 class="h3 mb-3 text-center"><strong>My Vehicles</strong> </h1>
                <br>
                <div class="row">
                    <div class="col-xl-6 col-xxl-5 d-flex">
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