@extends('layouts.app')

@section('content')
    @can('edit', $task)
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-5">
            <h1>Edit Task</h1>
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
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

                <div class="form-group mb-3">
                    <label for="assigned_to">Assign to:</label>
                    <select class="form-control" id="assigned_to" name="assigned_to" default=''>
                        @if (empty($task->assigned_to))
                            <option value="">---please select---</option>
                        @endif
                        @foreach ($user as $profile)
                            <option value="{{ $profile->id }}" {{ old('assigned_to') == $profile->id ? 'selected' : '' }}>
                                {{ $profile->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if (!empty($task->files))
                    <h4>已上傳檔案</h4>
                    @foreach ($task->files as $file)
                        <div class="mb-3">
                            <a
                                href="{{ Storage::url($file->file_path) }}">{{ $file->file_name ? $file->file_name : 'unknow' }}</a>
                            {{ formatSizeUnits(Storage::size('public/' . $file->file_path)) }}

                            <a href="{{ route('download_file', ['file_path' => $file->file_path]) }}" method='POST'
                                class="btn-sm btn-info text-white me-1">Download
                            </a>
                            <a href="#"
                                onclick="confirmDelete(event, '{{ route('delete_file', ['file_path' => $file->file_path]) }}')"
                                class="btn-sm btn-danger">Delete
                            </a>

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
    @endcan
@endsection
@push('scripts')
    <script>
        function confirmDelete(event, url) {
            event.preventDefault();
            var confirmAction = confirm("Are you sure you want to delete this item?");
            if (confirmAction) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Item deleted successfully.');
                        location.reload()
                    },
                    error: function(xhr) {
                        alert('An error occurred while deleting the item.');
                    }
                });
            }
        }
    </script>
@endpush
