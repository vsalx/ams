@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" id="dentist">Записване на час при <span id="{{$dentist->id}}">{{$dentist->name}}</span></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="col-md-12 text-center">
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Изберете дата от календара:
                                    </div>
                                    <div class="panel-body">
                                        <div id="appointment-calendar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="daySelect">
                                    </div>
                                    <div class="panel-body">
                                        <p id="day-times"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                    <button id="create-appointment" type="submit" class="btn btn-primary">Запази</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
