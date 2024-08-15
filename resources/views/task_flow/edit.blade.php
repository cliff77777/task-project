@extends('layouts.app')

@section('content')
    {{-- {{ dd($template) }} --}}
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">編輯任務流程</h1>
        <form action="{{ route('task_flow.update', $template['id']) }}" method="POST">
            @csrf
            @method('update')
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="task_flow_name" class="form-label">流程名稱</label>
                    <input type="text" class="form-control" id="task_flow_name" name="task_flow_name" required
                        value="{{ $template['task_flow_name'] }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="task_flow_step" class="form-label">流程步驟</label>
                <div id="formContainer">
                    @foreach ($template->steps as $step)
                        <div class="row align-items-center mb-3">
                            <!-- 第一個欄位 -->
                            <div class="col-md-1 align-items-center">
                                step.{{ $step->order }}
                                <input class="step" type='hidden' value="{{ $step['order'] }}"
                                    name="step[{{ $step->order }}]">
                            </div>
                            <div class="col-md-2">
                                <label for="sendEmailNotification" class="form-label">是否寄送郵件通知</label>
                                <div class="row">
                                    <div class="form-check col-md-6">
                                        <input class="form-check-input" type="radio"
                                            name="step[{{ $step['order'] }}][sendEmailNotification]"
                                            id="sendEmailNotificationOn_{{ $step['order'] }}"
                                            {{ $step['sendEmailNotification'] == 1 ? 'checked' : 'false' }} value="1">
                                        <label class="form-check-label" for="sendEmailNotificationOn">On</label>
                                    </div>
                                    <div class="form-check col-md-6">
                                        <input class="form-check-input" type="radio"
                                            name="step[{{ $step['order'] }}][sendEmailNotification]"
                                            id="sendEmailNotificationOff_{{ $step['order'] }}" value="0"
                                            {{ $step['sendEmailNotification'] == 0 ? 'checked' : 'flase' }}>
                                        <label class="form-check-label" for="sendEmailNotificationOff">Off</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="[{{ $step['order'] }}][to_role]" class="form-label">執行權限</label>
                                <select class="form-select" id="[1][to_role]" name="step[{{ $step['order'] }}][to_role]"
                                    required>
                                    @foreach ($user_role as $role)
                                        {
                                        <option value="{{ $role->id }}"
                                            {{ $step['to_role'] == $role->id ? 'selected' : '' }}>{{ $role['role_name'] }}
                                        </option>
                                        }
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="[1][descript]" class="form-label">職責說明</label>
                                <input type="text" name="step[1][descript]" class='form-control'
                                    {{ $step['order'] == 1 ? 'readonly' : '' }} value="{{ $step['descript'] }}">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <button type="submit" class="btn btn-primary mb-3">提交</button> --}}
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
