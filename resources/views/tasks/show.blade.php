@extends('layouts.app')

@section('content')
    <div class="col-md-1 ms-sm-auto col-lg-11 px-md-4">
        <h1 class="my-4">工作單詳情</h1>
        <div class="mb-4">
            <h4>
                <p><strong>主旨:</strong>{{ $task->subject }}</p>
            </h4>
            <p><strong>預計工時:</strong> {{ $task->estimated_hours }} 小時</p>
            <p><strong>創建人:</strong> {{ $task->creator->name }}</p>
            <p><strong>指派給:</strong> {{ $task->assignee->name ?? '未指派' }}</p>
            <p><strong>工作敘述:</strong></p>
            <p>
                <textarea class="form-control" readonly>{{ $task->description }}</textarea>
            <p>
        </div>
        {{-- @can('show', $task) --}}
        <div class="mb-4">
            <h3 class="mb-4">任務作業</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach ($task_note as $key => $note)
                @if (count($task_note) > $note['step'])
                    <form action="{{ route('update_task_note') }}" method="POST">
                    @else
                        <form action="{{ route('update_task_note_final') }}" method="POST">
                @endif

                @csrf
                {{-- {{ dd(['note' => $note['note']]) }} --}}
                <h4>Step{{ $note['step'] }}.{{ $note->task_flow_step['descript'] }}</h4>
                <div class="mb-3">
                    <label for="note" class="form-label">工作備註</label>
                    <textarea class="form-control" id="note" name="note" required>
                            {{ old('note', $note['note']) }}
                        </textarea>
                </div>
                <div class="mb-3">
                    <label for="actual_hours" class="form-label">實際工時</label>
                    <input type="number" step="0.1" class="form-control" id="actual_hours" name="actual_hours"
                        value="{{ old('actual_hours', $note['actual_hours']) }}" required>
                </div>

                <div class="mb-3">
                    <label for="actual_hours" class="form-label">工作狀態</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="">--please select--</option>
                        <option value="0" {{ $note['status'] == '0' ? 'selected' : '' }}>未完成</option>
                        <option value="1" {{ $note['status'] == '1' ? 'selected' : '' }}>完成</option>
                    </select>
                    <input type="text" name="note_id" hidden value="{{ $note['id'] }}">
                    <input type="text" name="task_id" hidden value="{{ $note['task_id'] }}">
                    <input type="text" name="step" hidden value="{{ $note['step'] }}">

                </div>
                {{-- {{ dd($task_note[$key + 1]->task_flow_step->role_to_user) }} --}}
                @if (count($task_note) > $note['step'])
                    <div class="mb-3">
                        <label for="assign_next" class="form-label">指派下一位</label>
                        <select class="mb-3 form-control" name="assign_next" id="assign_next">
                            @foreach ($task_note[$key + 1]->task_flow_step->role_to_user as $user)
                                <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                {{-- {{ dd([
                        'auth' => $auth,
                        'assign_to' => $note['assign_to'],
                        '1' => $auth == $note['assign_to'],
                        '2' => $get_task_next_step['step'] == $note['step'],
                        '3' => $get_task_next_step['status'] == 0,
                        'get_task_next_step_status' => $get_task_next_step['status'],
                        'get_task_next_step' => $get_task_next_step['step'],
                        'note_step' => $note['step'],
                    ]) }} --}}
                @if ($auth == $note['assign_to'] && $get_task_next_step['step'] == $note['step'] && $get_task_next_step['status'] == 0)
                    <button type="submit" class="btn btn-primary mb-3">流程處理</button>
                @elseif($auth == $note['assign_to'] && $get_task_next_step['step'] == $note['step'])
                    <div class="text-danger mb-3">程序處理中</div>
                @endif

                </form>
            @endforeach

        </div>
        {{-- @endcan --}}

        <div class="mb-4">
            <h4>上傳文件</h4>
            <form action="{{ route('upload_file', $task->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">選擇文件</label>
                    <input type="file" class="form-control" id="file" name="file" required>
                </div>
                <button type="submit" class="btn btn-primary">上傳</button>
            </form>
        </div>
    </div>
@endsection
