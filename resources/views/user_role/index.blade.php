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

        <h1 class="my-4">權限列表</h1>
        <div class="mb-4">
            <a href="{{ route('user_role.create') }}" class="btn btn-primary">新增權限</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>權限名稱</th>
                    <th>創建人</th>
                    <th>權限控制</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_role as $role)
                    <tr>
                        <td>{{ $role->role_name }}</td>
                        <td>{{ $role->username->name }}</td>
                        <td>{{ json_encode($role->role_control) }}</td>
                        <td>
                            <a href="{{ route('user_role.show', $role->id) }}" class="btn btn-sm btn-info">詳情</a>
                            {{-- @can('update', $task) --}}
                            <a href="{{ route('user_role.edit', $role->id) }}" class="btn btn-sm btn-warning">權限編輯</a>
                            {{-- <a onclick="confirmCancel(event, '{{ route('task_cancel') }}', {{ $task->id }})"
                                    class="btn-sm btn-danger">取消任務
                                </a> --}}
                            {{-- @endcan --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            @if ($user_role->onFirstPage())
                <!-- 如果在第一頁，不顯示上一頁按鈕 -->
            @else
                <a href="{{ $user_role->previousPageUrl() }}" class="btn btn-primary">上一頁</a>
            @endif

            @if ($user_role->hasMorePages())
                <a href="{{ $user_role->nextPageUrl() }}" class="btn btn-primary">下一頁</a>
            @endif
        </div>
    @endsection

    @push('scripts')
        <script>
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
