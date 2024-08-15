@extends('layouts.app')

@section('content')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 ">
        <h1 class="my-4">流程詳情</h1>
        <div class="mb-4">
            <div class="mb-2">
                <label for="task_flow_name" class="form-label">
                    <h4>流程名稱:</h4>
                </label>
                <input type="text" class="form-control w-25" value="{{ $template->task_flow_name }}" readonly>
            </div>

            <div class="mb-2">
                <label for="task_flow_name" class="form-label">
                    <h4>創建人:</h4>
                </label>
                <input type="text" class="form-control w-25" value="{{ $template->creator->name }}" readonly>
            </div>

            <div class="mb-2">
                <label for="task_flow_name" class="form-label">
                    <h4>最後更新人:</h4>
                </label>
                <input type="text" class="form-control w-25" value="{{ $template->updater->name }}" readonly>
            </div>

            <h4>
                <p><strong>步驟詳情 </strong></p>
            </h4>
            @foreach ($template->steps as $key => $step)
                <div class="accordion" id="accordionPanelsStayOpenstep" style="max-width: 18rem;">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne{{ $step->order }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#panelsStayOpen-collapseOne{{ $step->order }}" aria-expanded="true"
                                aria-controls="panelsStayOpen-collapseOne">
                                步驟{{ $step->order }}
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne{{ $step->order }}" class="accordion-collapse collapse show"
                            aria-labelledby="panelsStayOpen-headingOne{{ $step->order }}">
                            <div class="accordion-body">
                                <p><strong>需求權限:{{ $step->role_name }}</strong></p>
                                <p><strong>信箱驗證信:<font
                                            class="{{ $step->sendEmailNotification == 1 ? 'text-success' : 'text-danger' }}">
                                            {{ $step->sendEmailNotification == 1 ? 'ON' : 'OFF' }}</font>
                                    </strong></p>
                                <p><strong>步驟描述:{{ $step->descript }}</strong></p>
                                <p><strong>流程創建時間: {{ $step->created_at }}</strong></p>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@endsection
