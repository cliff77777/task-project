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

        <h1 class="my-4">流程列表</h1>
        <div class="mb-4">
            <a href="{{ route('task_flow.create') }}" class="btn btn-primary">新增任務流程</a>
        </div>
        @include('datatable.task_flow_table')
    @endsection

    @push('scripts')
        <script>
            function confirmCancel(event, url, template_id) {
                event.preventDefault();
                var confirmAction = confirm("Are you sure you want to delete this task flow?");
                if (confirmAction) {
                    console.log(template_id);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            'id': template_id
                        },
                        success: function(response) {
                            alert(response.message);
                            location.reload()
                        },
                        error: function(xhr) {
                            alert(xhr.message);
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
