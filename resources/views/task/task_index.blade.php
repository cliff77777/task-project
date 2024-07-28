@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebarMenu')
            <h1 class="my-4">工作單詳情</h1>
            <div class="mb-4">
                <h3>{{ $task->subject }}</h3>
                <p>{{ $task->description }}</p>
                <p><strong>預計工時:</strong> {{ $task->estimated_hours }} 小時</p>
                <p><strong>創建人:</strong> {{ $task->creator->name }}</p>
                <p><strong>指派給:</strong> {{ $task->assignee->name ?? '未指派' }}</p>
            </div>

            @can('update', $task)
                <div class="mb-4">
                    <h4>更新工作備註</h4>
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="note" class="form-label">工作備註</label>
                            <textarea class="form-control" id="note" name="note">{{ old('note', $task->note) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="actual_hours" class="form-label">實際工時</label>
                            <input type="number" step="0.1" class="form-control" id="actual_hours" name="actual_hours"
                                value="{{ old('actual_hours', $task->actual_hours) }}">
                        </div>
                        <button type="submit" class="btn btn-primary">更新</button>
                    </form>
                </div>
            @endcan

            <div class="mb-4">
                <h4>上傳文件</h4>
                <form action="{{ route('task_files.store', $task->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">選擇文件</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">上傳</button>
                </form>
            </div>
        </div>
    </div>
@endsection
