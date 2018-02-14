@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('/js/appointment-calendar.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div id="dentist" class="panel-heading"><span id="{{$dentist->id}}">Profile information</span></div>

                    <div class="panel-body">
                        <p><b>Name:</b> {{$dentist->name}}</p>
                        <p><b>City:</b> {{$dentist->city}}</p>
                        <p><b>Email:</b> {{$dentist->email}}</p>
                        <p><b>Type:</b> {{$dentist->type}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="panel panel-default">
                    <div class="panel-heading">Create appointment</div>
                    <div class="panel-body">
                        @if (session('appointment_status'))
                            <div class="alert alert-success col-md-5">
                                {{ session('appointment_status') }}
                            </div>
                        @else
                            <div class="col-md-3 col-lg-offset-1">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Choose date:
                                    </div>
                                    <div class="panel-body">
                                        <div id="appointment-calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="daySelect">
                                    </div>
                                    <div class="panel-body">
                                        <p id="day-times"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <form method="post" action="/dentist/{{$dentist->id}}/appointment">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="selected-date">Date:</label>
                                        <input id="selected-date" class="form-control" name="date"
                                               type="text" readonly/>
                                    </div>
                                    <div class="form-group row {{ $errors->has('time') ? ' has-error' : '' }}">
                                        <label for="selected-time">Hour:</label>
                                        <input id="selected-time" class="form-control" name="time"
                                               type="text" readonly value="{{ old('time') }}" required/>
                                        @if ($errors->has('time'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('time') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <button id="create-appointment" type="submit"
                                                class="btn btn-primary">Create appointment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Reviews
                <span class="pull-right">Rating: {{$dentist->reviews()->avg('rating')}}</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" action="/dentist/{{$dentist->id}}/review">
                            {{ csrf_field() }}
                            <div class="form-group row {{ $errors->has('comment') ? ' has-error' : '' }}">
                                <div class="col-md-7">
                                    <label for="comment">Write a review</label>
                                    <textarea class="form-control" rows="5" name="comment"
                                              id="comment" required></textarea>
                                    @if ($errors->has('comment'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('comment') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="rating">Rate</label>
                                    <select name="rating" id="rating" class="form-control">
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                    @if($i==5) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row col-md-1">
                                <button id="create-review" type="submit" class="btn btn-primary">Save review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                 <h2>Reviews</h2>
                @foreach($dentist->reviews as $review)
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            {{$review->reviewer->name}}
                            <span class="pull-right">Rate: {{$review->rating}}</span>
                        </div>
                        <div class="panel-body">
                            <p>{{$review->comment}}</p>
                        </div>
                    </div>
                @endforeach


   @if(session('saved_to_blacklist'))
        <div class="alert alert-danger">{{session('saved_to_blacklist')}}</div>
    @endif

    @if(session('remove_from_blacklist'))
        <div class="alert alert-info">{{session('remove_from_blacklist')}}</div>
    @endif
                <form method="post" action="/dentist/{{$dentist->id}}/blacklist">
                {{ csrf_field() }}  
                            <div class="form-group row col-md-9">
                                <button id="save-blacklist" type="submit" class="btn btn-danger">Save in blacklist
                                </button>
                            </div>
                </form>

                <form method="post" action="/dentist/{{$dentist->id}}/blacklistRemove">
                {{ csrf_field() }}  

                            <div class="form-group row col-md-1">
                                <button id="remove-blacklist" type="submit" class="btn btn-primary">Remove from blacklist
                                </button>
                            </div>
                </form>
            </div>
        </div>
    </div>
@endsection
