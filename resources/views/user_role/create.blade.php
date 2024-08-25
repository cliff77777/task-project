@extends('layouts.app')

@section('content')
    <div class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
        <h1 class="my-4">新增權限</h1>
        <form action="{{ route('user_role.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label for="user_role_name" class="form-label">權限名稱</label>
                    <input type="text" class="form-control" id="user_role_name" name="user_role_name" required>
                </div>
            </div>
            <div class="mb-3">
                <div id="formContainer">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-2">
                            <label for="user_role_descript" class="form-label">權限說明</label>
                            <input type="text" name="user_role_descript" class='form-control' required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div id="formContainer">
                    <div class="align-items-center mb-3">
                        <div class="col-md-2">
                            <label for="role_control" class="form-label">權限控制</label>
                        </div>
                        <label for="role_control[all]" class="form-label">全部控制</label>
                        <input type="checkbox" name="role_control[all]" class='form-checkbox' id="role_control[all]">

                        <label for="role_control[not_all]" class="form-label">部分控制</label>
                        <input type="checkbox" name="role_control[not_all]" class='form-checkbox'
                            id="role_control[not_all]">

                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3">提交</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
