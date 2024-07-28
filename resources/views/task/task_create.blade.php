@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebarMenu')
            <div class="col-md-8">
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <h1 class="my-4">新增工作單</h1>
                    <form action={{-- "{{ route('tasks.store') }}"  --}} method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label">主旨</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">工作內容說明</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="estimated_hours" class="form-label">預計工時</label>
                            <input type="number" step="0.1" class="form-control" id="estimated_hours"
                                name="estimated_hours" required>
                        </div>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </form>
                </main>
            </div>
        </div>
    </div>
@endsection
