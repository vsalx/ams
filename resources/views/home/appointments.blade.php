<div class="panel-heading">Your appointments</div>

<div class="panel-body">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Customer</th>
            <th>Dentist</th>
            <th>Cancelled on</th>
            <th>Cancelled by</th>
            <th>Cancel</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appointments as $appointment)
            <tr @if($appointment->cancelled_by != null) class="danger" @endif>
                <td>{{$appointment->appointment_date}}</td>
                <td>{{$appointment->appointment_time}}</td>
                <td>{{$appointment->customer->name}}</td>
                <td>{{$appointment->dentist->name}}</td>
                @if($appointment->cancelled_by != null)
                    <td>{{$appointment->cancelled_on}}</td>
                    <td>{{$appointment->cancelledBy->name}}</td>
                    <td>Cancelled</td>
                @else
                    <td>N/A</td>
                <td>N/A</td>
                    <td style="width: 10px" class="text-center">
                        <a href="/appointment/{{$appointment->id}}/cancel">
                            <span class="glyphicon glyphicon-remove" style="cursor: pointer; color: #c7254e">
                            </span>
                            </a>
                    </td>
                @endif


            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>