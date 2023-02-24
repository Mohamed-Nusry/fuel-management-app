<!DOCTYPE html>
<html>
<head>
    <title>Fuel Distribution Report - FuelIn</title>
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

    {{-- <p style="font-weight:bold">Total Income - LKR {{$total_income ?? 'N/A'}}</p> --}}

  
  
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Fuel Station</th>
            <th>Scheduled Date And Time</th>
            <th>Quota (Liters)</th>
            <th>Status</th>
            <th>Created On</th>
        </tr>
        @foreach($fueldists as $fueldist)
        <tr>
            <td>{{ $fueldist->id }}</td>
            <td>{{ ($fueldist->fuelStation && $fueldist->fuelStation != null) ? $fueldist->fuelStation->name : 'N/A'  }}</td>
            <td>{{ $fueldist->scheduled_date_time }}</td>
            <td>{{ $fueldist->quota }}</td>
            <td>{{ $fueldist->status }}</td>
            <td>{{ $fueldist->created_at }}</td>
        </tr>
        @endforeach
    </table>
  
</body>
</html>