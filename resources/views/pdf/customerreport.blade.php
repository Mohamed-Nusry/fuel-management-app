<!DOCTYPE html>
<html>
<head>
    <title>Customer Report - FuelIn</title>
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
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>District</th>
            <th>Created On</th>
        </tr>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->first_name }}</td>
            <td>{{ $customer->last_name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ ($customer->district && $customer->district != null) ? $customer->district->name : 'N/A'  }}</td>
            <td>{{ $customer->created_at }}</td>
        </tr>
        @endforeach
    </table>
  
</body>
</html>