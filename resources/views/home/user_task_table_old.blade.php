<div class="d-flex justify-content-center">
    <table class="table table-striped table-hover  w-75">
        <thead>
            <tr>
                <th>主旨</th>
                <th>任務概述</th>
                <th>預計工時/hr</th>
                <th>狀態</th>
                <th>創建人</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($get_user_task as $task)
                <tr>
                    <td>{{ $task['task']['subject'] }}</td>
                    <td>{{ $task['task']['description'] }}</td>
                    <td>{{ $task['task']['estimated_hours'] }}</td>
                    <td>{{ $task['status'] == 0 ? '未完成' : '已完成' }}</td>
                    <td>{{ $task['creator']['name'] }}</td>
                    <td><a href="{{ Route('tasks.show', $task['task_id']) }}"
                            class="btn btn-sm btn-info text-white">前往</a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
