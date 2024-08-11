@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">編輯權限</h1>
        <form action="{{ route('user_role.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label for="role_name" class="form-label">權限名稱</label>
                    <input type="text" class="form-control" id="role_name" name="role_name" required
                        value="{{ $role->role_name }}">
                </div>
            </div>
            <div class="mb-3">
                <div id="formContainer">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-2">
                            <label for="role_descript" class="form-label">權限說明</label>
                            <input type="text" name="role_descript" class='form-control' required
                                value="{{ $role->role_descript }}">
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
            <button type="submit" class="btn btn-primary mb-3">更新權限</button>
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
{{-- @push('scripts')
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
@endpush --}}
