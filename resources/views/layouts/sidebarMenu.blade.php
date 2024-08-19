<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                    {{ __('common.Dashboard') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    {{ __('common.Task Menu') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.create') }}">
                    {{ __('common.Add Task Tickets') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('activity_log.index') }}">
                    {{ __('common.Activity Log') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('task_flow.index') }}">
                    {{ __('common.Task Flow') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_manage.index') }}">
                    {{ __('common.User Manage') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_role.index') }}">
                    {{ __('common.User Role') }}
                </a>
            </li>
        </ul>
    </div>
</nav>
