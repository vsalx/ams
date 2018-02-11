    <div class="panel-heading">Search for customer</div>
    <div class="panel-body">
    <form method="post" action="/customer/search">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-3">
            <input name="name" class="form-control" placeholder="Name"/>
        </div>
        <div class="col-md-3">
            <input name="city" class="form-control" placeholder="City"/>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </div>
    </form>
    <div class="panel-heading">Enter work schedule</div>
    <hr/>
    <div class="panel-body">
    @if(session('schedule_validation'))
        <div class="alert alert-danger">{{session('schedule_validation')}}</div>
    @endif
    @if(session('schedule_created'))
        <div class="alert alert-info">{{session('schedule_created')}}</div>
    @endif
    <form id="schedule" method="post" action="/dentist/{{$user->id}}/schedule">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-3">
                <input class="form-control" placeholder="Choose date" id="date" name="date" readonly/>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="start_time" id="start_time">
                    <option selected disabled>From</option>
                    @for($hour = 0; $hour < 24; $hour++)
                        @for($min = 0; $min < 60; $min+=30)
                            <option value="{{str_pad($hour,2,'0',STR_PAD_LEFT)}}:{{str_pad($min,2,'0',STR_PAD_LEFT)}}">{{str_pad($hour,2,'0',STR_PAD_LEFT)}}
                                :{{str_pad($min,2,'0',STR_PAD_LEFT)}}</option>
                        @endfor
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="end_time" id="end_time">
                    <option selected disabled>To</option>
                    @for($hour = 0; $hour < 24; $hour++)
                        @for($min = 0; $min < 60; $min+=30)
                            <option value="{{str_pad($hour,2,'0',STR_PAD_LEFT)}}:{{str_pad($min,2,'0',STR_PAD_LEFT)}}">{{str_pad($hour,2,'0',STR_PAD_LEFT)}}
                                :{{str_pad($min,2,'0',STR_PAD_LEFT)}}</option>
                        @endfor
                    @endfor
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    <hr/>
    Schedules
    <hr/>
    <table class="table table-striped table-hover">
        <thead>
        <th>Date</th>
        <th>Start time</th>
        <th>End Time</th>
        </thead>
        <tbody>
        @foreach($schedules as $schedule)
            <tr>
                <td>{{$schedule->work_date}}</td>
                <td>{{$schedule->start_time}}</td>
                <td>{{$schedule->end_time}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</div>