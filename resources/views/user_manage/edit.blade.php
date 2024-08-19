@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">使用者編輯</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($success->all() as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('user_manage.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label for="name" class="form-label">使用者名稱</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                </div>
            </div>
            <div class="mb-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="role_descript" class="form-label">聯絡信箱</label>
                        <input type="text" name="role_descript" class='form-control' readonly
                            value="{{ $user->email }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="origin_password" class="form-label">原始密碼</label>
                        <input type="text" class='form-control' id='origin_password'>
                    </div>
                </div>
            </div>
            <span id="response_password_message"></span>
            <div class="mb-3">
                <div class="row align-items-center mb-3">
                    <div class="col-md-2">
                        <label for="password" class="form-label">修改密碼</label>
                        <input type="text" name="password" class='form-control' id="password"readonly>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h1 class="my-4"> 會員權限</h1>
                <div id="formContainer">
                    @foreach ($user_role as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="role{{ $role->id }}"
                                value='{{ $role->id }}'>
                            <label class="form-check-label" for="role{{ $role->id }}">
                                {{ $role->role_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3">更新使用者</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('origin_password').addEventListener('blur', function() {
            var origin_password = document.getElementById('origin_password').value;
            var password = document.getElementById('password');
            var origin_password_message = document.getElementById('response_password_message');
            $.ajax({
                url: '{{ route('password_check') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    'id': {{ $user->id }},
                    'origin_password': origin_password
                },
                success: function(response) {
                    origin_password_message.innerHTML = '<span class="text-success">' +
                        response.message + '</span>';
                    password.readOnly = false;;
                },
                error: function(xhr) {
                    // 錯誤時處理
                    var response = xhr.responseJSON;
                    if (response && response.message) {
                        origin_password_message.innerHTML = '<span class="text-danger">' + response
                            .message + '</span>';
                        password.readOnly = true;
                    } else {
                        origin_password_message.innerHTML = '<span class="text-danger">密碼驗證失敗</span>';
                        password.readOnly = true;
                    }
                }
            });
        });
    </script>
@endpush
