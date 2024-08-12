<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    Task Menu
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tasks.create') }}">
                    Add Task Tickets
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('activity_log.index') }}">
                    Activity Log
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('task_flow.index') }}">
                    Task Flow
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_manage.index') }}">
                    User Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user_role.index') }}">
                    User Role
                </a>
            </li>
        </ul>
    </div>
</nav>
