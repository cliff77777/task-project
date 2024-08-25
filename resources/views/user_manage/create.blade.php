@extends('layouts.app')

@section('content')
    <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
        <h1 class="my-4">新增使用者</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user_manage.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label for="name" class="form-label">使用者名稱</label>
                    <input type="text" class="form-control" id="name" name="name" required
                        value="{{ old('name') }}">
                </div>
            </div>
            <div class="mb-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="email" class="form-label">使用者信箱</label>
                        <input type="text" name="email" class='form-control'id="email" required
                            value="{{ old('email') }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="password" class="form-label">密碼</label>
                        <input type="password" name="password" class='form-control'id="password" required
                            value="{{ old('password') }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="password_confirmation" class="form-label">再次確認密碼</label>
                        <input type="text" name="password_confirmation" class='form-control'id="password_confirmation"
                            required value="{{ old('password_confirmation') }}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <h1 class="my-4"> 會員權限</h1>
                <div id="formContainer">
                    @foreach ($user_role as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="role{{ $role->id }}"
                                {{ old('role') == $role->id ? 'checked' : '' }} value='{{ $role->id }}'>
                            <label class="form-check-label" for="role{{ $role->id }}">
                                {{ $role->role_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3">提交</button>
        </form>
    </div>
@endsection
