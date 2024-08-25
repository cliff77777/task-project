@extends('layouts.app')

@section('content')
    {{-- {{ dd($assign_user) }} --}}
    @can('edit', $task)
        <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4 mt-5">
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
                    <label for="task_flow_template_id">任務流程</label>
                    @if (empty($task->task_flow_template))
                        <select class="form-control" id="task_flow_template_id" name="task_flow_template_id">
                            <option value="">---please select---</option>
                            @foreach ($task_flow_template as $template)
                                <option value="{{ $template->id }}">

                                </option>
                            @endforeach
                        @else
                            <input type="text" class="form-control" readonly
                                value="{{ $task->task_flow_template->task_flow_name }}">
                            <input type="text" class="form-control" readonly hidden
                                value="{{ $task->task_flow_template->id }}" id="task_flow_template_id"
                                name="task_flow_template_id">
                    @endif

                    </select>
                </div>
                {{-- {{ dd($check_task_step_status->status) }} --}}
                <div class="form-group mb-3">
                    <label for="assigned_to">分配給:</label>
                    @if (!empty($task->assigned_to))
                        <select class="form-control" id="assigned_to" name="assigned_to"
                            {{ $check_task_step_status->status !== '0' ? 'success' : 'disabled' }}>
                            <option value="">---請先選擇任務流程---</option>
                            @foreach ($assign_user as $key => $user)
                                <option value="{{ $user['id'] }}"
                                    {{ $task->task_flow_template_id == $user['id'] ? 'selected' : 'false' }}>
                                    {{ $user['name'] }}</option>
                            @endforeach
                        </select>
                    @else
                        <select class="form-control" id="assigned_to" name="assigned_to">
                            <option value="">---請選擇---</option>
                            @foreach ($assign_user as $user)
                                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                    @endif

                </div>

                <input type="text" name="task_id" value="{{ $task->id }}" hidden>

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


        $('#task_flow_template_id').on('change', function() {
            var task_flow_template = $('#task_flow_template_id').val();
            var assigned_to = $('#assigned_to');
            assigned_to.empty();
            if (task_flow_template) {
                $.ajax({
                    url: '{{ route('get_task_assign') }}',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        'task_flow_template_id': task_flow_template,
                    },
                    success: function(response) {
                        // console.log(count(response));
                        assigned_to.prop('disabled', false); // 取消禁用select
                        if (response === null || response === undefined) {
                            assigned_to.empty();
                            assigned_to.append('<option value="">---沒有找到符合的用戶---</option>');
                            assigned_to.prop('disabled', true); // 禁用select
                        } else {
                            assigned_to.empty();
                            assigned_to.append('<option value="">---請選擇---</option>');
                            $.each(response.success, function(key, value) {
                                assigned_to.append('<option value="' + value.id + '">' + value
                                    .name +
                                    '</option>');
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('發生錯誤:', xhr);
                        // 處理錯誤情況
                        assign_error_msg.text('發生錯誤，請稍後再試。').attr('hidden', false);
                        assigned_to.prop('disabled', true); // 禁用select
                    }
                });
            } else {
                assigned_to.append('<option value="" >---請先選擇任務流程---</option>');
                assigned_to.prop('disabled', true);
            }
        });
    </script>
@endpush
