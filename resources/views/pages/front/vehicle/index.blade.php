@extends('layouts.front')


@section('content')


<div class="wrapper">
    <div class="main">
        <main class="content">
            <div class="container-fluid p-5 ">

                <h1 class="h1 mb-3 text-center"><strong>{Your Vehicle}</strong> </h1>
                <br>
                <div class="row ">
                    <div class="col-xl-12 col-xxl-5 d-flex">
                        <p>Remaining Quota = 10 liters</p>
                    </div>
                    <div class="col-xl-12 col-xxl-5 d-flex">
                        <button>Request Fuel</button>
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