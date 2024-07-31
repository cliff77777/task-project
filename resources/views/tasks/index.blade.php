@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">任務列表</h1>
        <div class="mb-4">
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">新增任務單</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>主旨</th>
                    <th>任務內容說明</th>
                    <th>預計工時</th>
                    <th>創建人</th>
                    <th>指派給</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->subject }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->estimated_hours }}</td>
                        <td>{{ $task->creator->name }}</td>
                        <td>{{ $task->assignee->name ?? '未指派' }}</td>
                        <td>
                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">任務處理</a>
                            @can('update', $task)
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">編輯</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tasks->links() }}
    </div>
@endsection
