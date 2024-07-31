@extends('layouts.app')
@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="col-md-8 mt-3 ">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
@endsection
