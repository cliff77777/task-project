@extends('layouts.app')
@section('content')
    <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
        <div class="mt-3 ">
            <div class="card vh-100">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @include('chart')
                    @include('home.user_task_table')
                </div>
            </div>
        </div>
    </div>
@endsection
