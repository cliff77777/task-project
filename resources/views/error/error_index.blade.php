@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Error Content') }}</div>
                    <div class="card-body">
                        <div class="alert alert-danger" role="alert">
                            <div>{{ session('error') }}</div>
                            @if (session('error') == 'Your email is not verified.')
                                {{ __('If you did not receive the email') }},
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to resend verity email') }}
                                    </button>.
                                </form>
                            @else
                                {{ __(session('error')) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
