<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Report - FuelIn</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">{{ $title }}</h1>
    @if($from_date != null && $to_date != null)
        <p>{{ "From - ".$from_date  }}</p>
        <p>{{ "To - ".$to_date  }}</p>
    @else
        @if($from_date != null && $to_date == null)
            <p>{{ "From - ".$from_date  }}</p>
            <p>{{ "To - End" }}</p>
        @else
            @if($to_date != null && $from_date == null)
                <p>{{ "From - Beginning"  }}</p>
                <p>{{ "To - ".$to_date  }}</p>
            @else
                <p>{{ "From Beginning To End"}}</p>
            @endif
        @endif
    @endif

  
  
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Reference</th>
            <th>Customer</th>
            <th>Vehicle</th>
            <th>Vehicle Registration</th>
            <th>Chasis No</th>
            <th>Available Quota (Liters)</th>
            <th>Created On</th>
        </tr>
        @foreach($vehicles as $vehicle)
        <tr>
            <td>{{ $vehicle->id }}</td>
            <td>{{ $vehicle->reg_id }}</td>
            <td>{{ ($vehicle->customer && $vehicle->customer != null) ? $vehicle->customer->first_name.' '.$vehicle->customer->last_name : 'N/A'  }}</td>
            <td>{{ ($vehicle->vehicle && $vehicle->vehicle != null) ? $vehicle->vehicle->name : 'N/A'  }}</td>
            <td>{{ $vehicle->vehicle_registration_number }}</td>
            <td>{{ $vehicle->chassis_no }}</td>
            <td>{{ $vehicle->available_quota }}</td>
            <td>{{ $vehicle->created_at }}</td>
        </tr>
        @endforeach
    </table>
  
</body>
</html>