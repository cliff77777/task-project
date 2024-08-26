@extends('layouts.app')
@section('content')
    <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
        <h1 class="my-4">操作紀錄</h1>
        @include('datatable.activity_log_table')
    </div>
    </div>
@endsection
