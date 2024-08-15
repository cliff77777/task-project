@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">新增工作單</h1>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3 col-md-3">
                <label for="subject" class="form-label">主旨</label>
                <input type="text" class="form-control" id="subject" name="subject">
            </div>
            <div class="mb-3 col-md-6">
                <label for="description" class="form-label">工作內容說明</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3 col-md-2">
                <label for="estimated_hours" class="form-label">預計工時/hr</label>
                <input type="number" step="0.1" class="form-control" id="estimated_hours" name="estimated_hours"
                    required>
            </div>
            <div class="mb-3 col-md-3">
                <label for="task_flow_template" class="form-label">工作流程</label>
                <select class="form-control" id="task_flow_template" name="task_flow_template_id"required>
                    @foreach ($task_flow_template as $template)
                        <option value="{{ $template->id }}">{{ $template->task_flow_name }}</option>
                    @endforeach
                </select>
            </div>
            <h4>檔案上傳</h4>
            <div class="mb-3 col-md-3">
                <label for="file" class="form-label">選擇文件</label>
                <input type="file" class="form-control" id="file" name="file">
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
