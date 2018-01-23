@extends('layouts.app')
@section('scripts')
    <script src="{{ asset('/js/schedule.js') }}"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('home.appointments')
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="panel panel-default">

                        @if($user->type == 'CUSTOMER')
                            @include('home.customer')
                        @else
                            @include('home.dentist')
                        @endif
                    </div>
                </div>
            </div>
@endsection
