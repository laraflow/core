@extends('laraflow::auth.auth-layout')

@section('title', 'Register')

@push('meta')

@endpush

@push('webfont')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@push('page-style')

@endpush

@section('body-class', 'register-page')

@section('content')
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
            {!! \Form::open(['route' => 'backend.auth.register', 'id' => 'register-form', 'method' => 'post']) !!}

            {!! \Form::iText('name', __('Name'), null, true, "fas fa-font", "after",
            [ 'minlength' => '2', 'maxlength' => '255',
                            'size' => '255', 'placeholder' => 'Enter Full Name']) !!}

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
                                    [ 'minlength' => '5', 'maxlength' => '255',
                                        'size' => '255', 'placeholder' => 'Enter Username']) !!}
            @endif

            @if(config('laraflow.auth.credential_field') != \Constant::LOGIN_OTP)
                {!! \Form::iPassword('password', __('Password'), true, "fas fa-lock", "after",
                                    ["placeholder" => 'Enter Password', 'minlength' => '5',
                                     'maxlength' => '255', 'size' => '255']) !!}

                {!! \Form::iPassword('password_confirmation', __('Retype Password'), true, "fas fa-lock", "after",
                                    ["placeholder" => 'Retype Password', 'minlength' => '5',
                                     'maxlength' => '255', 'size' => '255']) !!}

            @endif
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        {!! \Form::checkbox('agree_terms', 'agree', null, ['id' => 'agree_terms']) !!}
                        <label for="agree_terms">
                            I agree to the <a href="{{ route('backend.auth.terms') }}" target="_blank">terms</a>
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-success btn-block">{{ __('Register') }}</button>
                </div>
                <!-- /.col -->
            </div>
            {!! \Form::close() !!}

            @if(\Route::has('backend.auth.login'))
                <p class="mb-0">
                    <a href="{{ route('backend.auth.login') }}" class="text-center">I already have a membership</a>
                </p>
            @endif

            @if (\Route::has('backend.auth.password.request') && config('laraflow.auth.allow_password_reset'))
                <p class="mb-1">
                    <a href="{{ route('backend.auth.password.request') }}">I forgot my password</a>
                </p>
            @endif
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection


@push('plugin-script')
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
@endpush

@push('page-script')
    <script type="text/javascript">
        $(function () {
            $("#register-form").validate({
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

