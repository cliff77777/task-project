@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebarMenu')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Work Menu</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <span data-feather="calendar"></span>
                            This week
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">主旨</th>
                                <th scope="col">簡介</th>
                                <th scope="col">分類</th>
                                <th scope="col">創建時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($tickets))
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ $ticket->description }}</td>
                                        <td>{{ $ticket->category }}</td>
                                        <td>{{ $ticket->created_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>default</td>
                                    <td>default</td>
                                    <td>default</td>
                                    <td>default</td>
                                    <td>default</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{-- {{ $tickets->links() }} --}}
                </div>
            </main>
        </div>
    </div>
@endsection
