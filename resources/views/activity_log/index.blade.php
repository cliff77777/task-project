@extends('layouts.app')
@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <h1>Activity Log</h1>
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Subject Type</th>
                    <th>Subject ID</th>
                    <th>Causer Type</th>
                    <th>Causer ID</th>
                    <th>User Name</th>
                    <th>Properties</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->subject_type }}</td>
                        <td>{{ $activity->subject_id }}</td>
                        <td>{{ $activity->causer_type }}</td>
                        <td>{{ $activity->causer_id }}</td>
                        <td>{{ $activity->user->name }}</td>
                        <td>{{ json_encode($activity->properties) }}</td>
                        <td>{{ $activity->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            @if ($activities->onFirstPage())
                <!-- 如果在第一頁，不顯示上一頁按鈕 -->
            @else
                <a href="{{ $activities->previousPageUrl() }}" class="btn btn-primary">上一頁</a>
            @endif

            @if ($activities->hasMorePages())
                <a href="{{ $activities->nextPageUrl() }}" class="btn btn-primary">下一頁</a>
            @endif
        </div>
    </div>
@endsection
