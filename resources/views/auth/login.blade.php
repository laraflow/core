@extends('laraflow::auth.auth-layout')

@section('title', 'Login')

@push('meta')

@endpush


@push('page-style')

@endpush

@section('body-class', 'login-page')

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            {!! \Form::open(['route' => 'backend.auth.login', 'id' => 'login-form', 'method' => 'post']) !!}

            @if(config('laraflow.auth.credential_field') == \Constant::LOGIN_EMAIL
            || (config('laraflow.auth.credential_field') == \Constant::LOGIN_OTP
                && config('laraflow.auth.credential_otp_field') == \Constant::OTP_EMAIL))
                {!! \Form::iEmail('email', __('Email'), null, true, "fas fa-envelope", "after",
                                    [ 'minlength' => '5', 'maxlength' => '250',
                                        'size' => '250', 'placeholder' => 'Enter Email Address']) !!}
            @endif

            @if(config('laraflow.auth.credential_field') == \Constant::LOGIN_MOBILE
            || (config('laraflow.auth.credential_field') == \Constant::LOGIN_OTP
                && config('laraflow.auth.credential_otp_field') == \Constant::OTP_MOBILE))
                {!! \Form::iTel('mobile', __('Mobile'), null, true, "fas fa-mobile", "after",
                                    [ 'minlength' => '11', 'maxlength' => '11',
                                        'size' => '11', 'placeholder' => 'Enter Mobile Number']) !!}
            @endif

            @if(config('laraflow.auth.credential_field') == \Constant::LOGIN_USERNAME)
                {!! \Form::iText('username', __('Username'), null, true, "fas fa-user-shield", "after",
                                    [ 'minlength' => '5', 'maxlength' => '250',
                                        'size' => '250', 'placeholder' => 'Enter Username']) !!}
            @endif

            @if(config('laraflow.auth.credential_field') != \Constant::LOGIN_OTP)
                {!! \Form::iPassword('password', __('Password'), true, "fas fa-lock", "after",
                                    ["placeholder" => 'Enter Password', 'autocomplete' => "current-password",
                                     'minlength' => '5', 'maxlength' => '250', 'size' => '250']) !!}
            @endif

            <div class="row mb-4">
                @if(config('laraflow.auth.allow_remembering'))
                    <div class="col-8">
                        <div class="icheck-primary">
                            {!! \Form::checkbox('remember', 'yes', null, ['id' => 'remember_me']) !!}
                            <label for="remember_me">
                                {{ __('Remember me') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                @endif
                <div class="@if(!config('laraflow.auth.allow_remembering')) offset-8 @endif col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                </div>
                <!-- /.col -->
            </div>
            {!! \Form::close() !!}

            @if (\Route::has('backend.auth.password.request'))
                <p class="mb-1">
                    <a href="{{ route('backend.auth.password.request') }}">I forgot my password</a>
                </p>
            @endif

            @if(\Route::has('backend.auth.register'))
                <p class="mb-0">
                    <a href="{{ route('backend.auth.register') }}" class="text-center">Register a new account</a>
                </p>
            @endif
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection


@push('plugin-script')
    <!-- jquery validation -->
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-script')
    <script type="text/javascript">
        $(function () {
            $("#login-form").validate({
                rules: {
                    @if(config('laraflow.auth.credential_field') == \Constant::LOGIN_EMAIL
                    || (config('laraflow.auth.credential_field') == \Constant::LOGIN_OTP
                    && config('laraflow.auth.credential_otp_field') == \Constant::OTP_EMAIL))
                    email: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                        email: true
                    },
                    @endif

                        @if(config('laraflow.auth.credential_field') == \Constant::LOGIN_MOBILE
                        || (config('laraflow.auth.credential_field') == \Constant::LOGIN_OTP
                        && config('laraflow.auth.credential_otp_field') == \Constant::OTP_MOBILE))
                    mobile: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        digits: true
                    },
                    @endif

                        @if(config('laraflow.auth.credential_field') == \Constant::LOGIN_USERNAME)
                    username: {
                        required: true,
                        minlength: 5,
                        maxlength: 250
                    },
                    @endif

                        @if(config('laraflow.auth.credential_field') != \Constant::LOGIN_OTP)
                    password: {
                        required: true,
                        minlength: {{ config('laraflow.auth.minimum_password_length') }},
                        maxlength: 250
                    }
                    @endif
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-valid').addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                }
            });
        });
    </script>
@endpush
