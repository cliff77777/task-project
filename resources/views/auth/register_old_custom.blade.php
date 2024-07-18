<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('common.Register') }}</div>
                    <div class="card-body">
                        <form id="registration-form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('common.Name') }}</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('common.Phone') }}</label>
                                <input id="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="tel">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('common.E-Mail Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="invalid-feedback" id='email-error'>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('common.Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password-confirm"
                                    class="form-label">{{ __('common.Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <div class="invalid-feedback">
                                    {{ __('common.Passwords do not match') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('common.Register') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password-confirm');
            const invalidFeedback = passwordConfirm.nextElementSibling;

            passwordConfirm.addEventListener('input', function() {
                if (password.value !== passwordConfirm.value) {
                    passwordConfirm.classList.add('is-invalid');
                    passwordConfirm.setCustomValidity('{{ __('common.Passwords do not match') }}');
                    invalidFeedback.style.display = 'block';
                } else {
                    passwordConfirm.classList.remove('is-invalid');
                    passwordConfirm.setCustomValidity('');
                    invalidFeedback.style.display = 'none';
                }
            });
        });


        // JavaScript for unique email validation
        document.getElementById('email').addEventListener('blur', function() {
            var email = this.value.trim();
            const emailError = document.getElementById('email-error');
            if (email !== '') {
                fetch('/check-email/' + email)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            document.getElementById('email-error').textContent =
                                '{{ __('common.Email already exists.') }}';
                            emailError.classList.add('is-invalid');
                            emailError.style.display = 'block';
                        } else {
                            document.getElementById('email-error').textContent = '';
                            emailError.classList.remove('is-invalid');
                            // passwordConfirm.setCustomValidity('');
                            emailError.style.display = 'none';
                        }
                    });
            }
        });
    </script>
@endsection
