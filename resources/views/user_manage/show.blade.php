@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">使用者詳情</h1>
        <div class="row">
            <div class="mb-3 col-md-2">
                <label for="name" class="form-label">使用者名稱</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>
        </div>
        <div class="mb-3">
            <div id="formContainer">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="email" class="form-label">使用者信箱</label>
                        <input type="text" value="{{ $user->email }}" class='form-control' readonly>
                        @if (empty($user->email_verified_at))
                            <span class='text-danger'>未驗證</span>
                        @else
                            <span class='text-success'>已驗證</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div id="formContainer">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="role" class="form-label">使用者權限</label>
                        <input type="text" value="{{ $user->role_name }}" class='form-control' readonly>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('user_manage.edit', $user->id) }}" class="btn btn-info text-white" method="GET">前往更新</a>
    @endsection
