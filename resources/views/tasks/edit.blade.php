{{-- resources/views/tasks/edit.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">
        <h1>Edit Task</h1>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" id="subject" name="subject"
                    value="{{ old('subject', $task->subject) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="estimated_hours">Estimated Hours:</label>
                <input type="number" class="form-control" id="estimated_hours" name="estimated_hours"
                    value="{{ old('estimated_hours', $task->estimated_hours) }}" required>
            </div>
            @if (!empty($task->files))
                @foreach ($task->files as $file)
                    .
                    <h4>已上傳檔案</h4>
                    <div class="mb-3">
                        <a href="{{ Storage::url($file->path) }}">View File</a>
                    </div>
                @endforeach
            @endif
            <h4>檔案上傳</h4>
            <div class="mb-3">
                <label for="file" class="form-label">選擇文件</label>
                <input type="file" class="form-control" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
@endsection
