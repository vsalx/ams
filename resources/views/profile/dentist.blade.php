@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('/js/appointment-calendar.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @if(!empty($message))
                <div class="aler alert-success">{{$message}}</div>
                @endif
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div id="dentist" class="panel-heading"><span id="{{$dentist->id}}">{{$dentist->name}}</span><span class="pull-right">Рейтинг: {{$dentist->reviews()->avg('rating')}}</span> </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="container">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="col-md-offset-1 col-md-3">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                Изберете дата от календара:
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
                                                <label for="selected-date">Дата:</label>
                                                <input id="selected-date" class="form-control" name="date" type="text" readonly />
                                            </div>
                                            <div class="form-group row">
                                                <label for="selected-time">Час:</label>
                                                <input id="selected-time" class="form-control" name="time" type="text" readonly />
                                            </div>
                                            <div class="form-group row">
                                                <button id="create-appointment" type="submit" class="btn btn-primary">Запази час</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="/dentist/{{$dentist->id}}/review">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <div class="col-md-7">
                                            <label for="comment">Напиши коментар и дай оценка</label>
                                            <textarea class="form-control" rows="5" name="comment" id="comment"></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="rating">Оценка</label>
                                                <select name="rating" id="rating" class="form-control">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}" @if($i==5) selected @endif>{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row col-md-1">
                                            <button id="create-review" type="submit" class="btn btn-primary">Запази ревю</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                            <h2>Ревюта</h2>
                        @foreach($dentist->reviews as $review)
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    {{$review->reviewer->name}}
                                    <span class="pull-right">Оценка: {{$review->rating}}</span>
                                </div>
                                <div class="panel-body">
                                    <p>{{$review->comment}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
