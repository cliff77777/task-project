@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="container mt-5">
            @if (session('success'))
                <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <h1 class="my-4">流程列表</h1>
        <div class="mb-4">
            <a href="{{ route('task_flow.create') }}" class="btn btn-primary">新增任務流程</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>流程名稱</th>
                    <th>創建人</th>
                    <th>流程步驟</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    {{-- <td>
                            <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info">任務處理</a>
                            @can('update', $task)
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">編輯</a>
                                <a onclick="confirmCancel(event, '{{ route('task_cancel') }}', {{ $task->id }})"
                                    class="btn-sm btn-danger">取消任務
                                </a>
                            @endcan
                        </td> --}}
                </tr>
            </tbody>
        </table>
        {{-- {{ $tasks->links() }} --}}
    @endsection

    @push('scripts')
        <script>
            function confirmCancel(event, url, task_id) {
                event.preventDefault();
                var confirmAction = confirm("Are you sure you want to cancel this task?");
                if (confirmAction) {
                    console.log(task_id);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            'id': task_id
                        },
                        success: function(response) {
                            alert(response.message);
                            location.reload()
                        },
                        error: function(xhr) {
                            alert('An error occurred while cancel the task.');
                        }
                    });
                }
            }
            $(document).ready(function() {
                // 自動隱藏成功提示
                var successAlert = $('#successAlert');
                if (successAlert.length) {
                    setTimeout(function() {
                        successAlert.fadeOut('slow', function() {
                            $(this).alert('close');
                        });
                    }, 3000); // 3 秒後自動關閉
                }

                // 自動隱藏錯誤提示
                var errorAlert = $('#errorAlert');
                if (errorAlert.length) {
                    setTimeout(function() {
                        errorAlert.fadeOut('slow', function() {
                            $(this).alert('close');
                        });
                    }, 3000); // 3 秒後自動關閉
                }
            });
        </script>
    @endpush