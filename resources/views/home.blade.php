@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Your appointments</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Search for @if($user->type == 'CUSTOMER') dentist @else customer @endif</div>
                    <div class="panel-body">
                        @if($user->type == 'CUSTOMER')
                            @include('home.customer')
                        @else
                            @include('home.dentist')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
