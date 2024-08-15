@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="my-4">新增任務流程</h1>
        <form action="{{ route('task_flow.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="flow_name" class="form-label">流程名稱</label>
                    <input type="text" class="form-control" id="flow_name" name="flow_name" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="task_flow_step" class="form-label">流程步驟</label>
                <div id="formContainer">
                    <div class="row align-items-center mb-3">
                        <!-- 第一個欄位 -->
                        <div class="col-md-1 align-items-center">
                            step.1
                            <input class="step" type='hidden' value="1" name="step[1]">
                        </div>
                        <div class="col-md-2">
                            <label for="sendEmailNotification" class="form-label">是否寄送郵件通知</label>
                            <div class="row">
                                <div class="form-check col-md-6">
                                    <input class="form-check-input" type="radio" name="step[1][sendEmailNotification]"
                                        id="sendEmailNotificationOn" value="1" checked>
                                    <label class="form-check-label" for="sendEmailNotificationOn">On</label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input class="form-check-input" type="radio" name="step[1][sendEmailNotification]"
                                        id="sendEmailNotificationOff" value="0">
                                    <label class="form-check-label" for="sendEmailNotificationOff">Off</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="[1][to_role]" class="form-label">執行權限</label>
                            <select class="form-select" id="[1][to_role]" name="step[1][to_role]" required>
                                @foreach ($user_role as $role)
                                    {
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    }
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="[1][descript]" class="form-label">職責說明</label>
                            <input type="text" name="step[1][descript]" class='form-control' readonly value="任務指派">
                        </div>
                    </div>
                </div>
                <a id="addRow" class="btn btn-primary">+</a>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let formContainer = document.getElementById('formContainer');
            let addRowButton = document.getElementById('addRow');
            let currentStep = 1;

            addRowButton.addEventListener('click', function() {
                currentStep++;

                let newRow = document.createElement('div');
                newRow.innerHTML =
                    `
                    <div class="row align-items-center mb-3" id='newRow${currentStep}'>
                        <div class="col-md-1">
                            step.${currentStep}
                            <input type="hidden" class="step" value="${currentStep}" name="step[${currentStep}]">
                        </div>
                       <div class="col-md-2">
                            <label for="sendEmailNotification" class="form-label">是否寄送郵件通知</label>
                            <div class="row">
                                <div class="form-check col-md-6">
                                    <input class="form-check-input" type="radio" name="step[${currentStep}][sendEmailNotification]"
                                        id="sendEmailNotificationOn" value="1" checked>
                                    <label class="form-check-label" for="sendEmailNotificationOn">On</label>
                                </div>
                                <div class="form-check col-md-6">
                                    <input class="form-check-input" type="radio" name="step[${currentStep}][sendEmailNotification]"
                                        id="sendEmailNotificationOff" value="0">
                                    <label class="form-check-label" for="sendEmailNotificationOff">Off</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="[${currentStep}][to_role]" class="form-label">執行權限</label>
                            <select class="form-select" id="[${currentStep}][to_role]" name="step[${currentStep}][to_role]" required>
                                @foreach ($user_role as $role)
                                    {
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    }
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="[${currentStep}][descript]" class="form-label">職責說明</label>
                            <input type="text" name="step[${currentStep}][descript]" class='form-control' required>
                        </div>
                        <div class="col-md-2 ">
                            <a id="delRow${currentStep}" class="btn  btn-sm btn-danger">X</a>
                        </div>
                    </div>
                `;
                formContainer.appendChild(newRow);
                // 直接為新添加的刪除按鈕綁定點擊事件
                document.getElementById(`delRow${currentStep}`).addEventListener('click', function() {
                    formContainer.removeChild(newRow);
                });
            });



        });
    </script>
@endpush
