@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Записване на час</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="col-md-10 text-center">
                            <div class="col-md-5">
                                <div id="booking-calendar"></div>
                            </div>
                            <div class="col-md-5">
                                <div class="panel panel-primary">
                                    <div class="panel-heading" id="daySelect">
                                    </div>
                                    <div class="panel-body">
                                        <p id="dayTimes"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
