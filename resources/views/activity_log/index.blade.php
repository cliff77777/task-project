@extends('layouts.app')
@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1>Activity Log</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
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
                            <td>{{ $activity->causer_type ?? 'System Default' }}</td>
                            <td>{{ $activity->causer_id ?? 'System Default' }}</td>
                            <td>{{ $activity->user->name ?? 'System Default' }}</td>
                            <td>{{ json_encode($activity->properties) }}</td>
                            <td>{{ $activity->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- 顯示分頁鏈接 -->
            <div class="d-flex justify-content-center mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
@endsection
