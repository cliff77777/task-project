@extends('layouts.app')

@section('content')
    <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
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

        <h1 class="my-4">使用者列表</h1>
        <div class="mb-4">
            <a href="{{ route('user_manage.create') }}" class="btn btn-primary">新增使用者</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>使用者帳號</th>
                    <th>創建時間</th>
                    <th>權限</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->role_name }}</td>
                        <td>
                            <a href="{{ route('user_manage.show', $user->id) }}" class="btn btn-sm btn-info">詳情</a>
                            {{-- @can('update', $task) --}}
                            <a href="{{ route('user_manage.edit', $user->id) }}" class="btn btn-sm btn-warning">使用者編輯</a>
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
            @if ($users->onFirstPage())
                <!-- 如果在第一頁，不顯示上一頁按鈕 -->
            @else
                <a href="{{ $users->previousPageUrl() }}" class="btn btn-primary">上一頁</a>
            @endif

            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="btn btn-primary">下一頁</a>
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
