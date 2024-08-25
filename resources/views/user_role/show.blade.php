@extends('layouts.app')

@section('content')
    <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
        <h1 class="my-4">權限列表</h1>
        <div class="row">
            <div class="mb-3 col-md-2">
                <label for="user_role_name" class="form-label">權限名稱</label>
                <input type="text" class="form-control" value="{{ $role->role_name }}" readonly>
            </div>
        </div>
        <div class="mb-3">
            <div id="formContainer">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="user_role_descript" class="form-label">權限說明</label>
                        <input type="text" value="{{ $role->role_descript }}" class='form-control' readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div id="formContainer">
                <div class="align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="role_control" class="form-label">權限控制</label>
                        {{-- </div>
                    <label for="role_control[all]" class="form-label">全部控制</label>
                    <input type="checkbox" name="role_control[all]" class='form-checkbox' id="role_control[all]" readonly
                        {{ isset($role->role_control->all) ? 'checked' : 'false' }}>
                    <label for="role_control[not_all]" class="form-label">部分控制</label>
                    <input type="checkbox" name="role_control[not_all]" class='form-ch""eckbox' id="role_control[not_all]"
                        readonly {{ isset($role->role_control->not_all) ? 'checked' : '' }}> --}}
                    </div>
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>使用者名稱</th>
                        <th>權限</th>
                        <th>創建日期</th>
                    </tr>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
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
            </div>
        </div>
    @endsection
