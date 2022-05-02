<?php
// config for Laraflow/Laraflow
return [

    'auth' => [
        /*
         * --------------------------------------------------------------------
         * Eloquent Model FullPath
         * --------------------------------------------------------------------
         *
         * Adding a Prefix to Admin Login Routes  Group
         * If there are to section like frontend & backend
         * then make route separate route group
         *
         * @var string
         * @example 'App\Models\User'
         * @example 'User::class'
         */
        'user' => 'App\Models\User',

        /*
         * --------------------------------------------------------------------
         * Prefix  for Admin Login Route
         * --------------------------------------------------------------------
         *
         * Adding a Prefix to Admin Login Routes  Group
         * If there are to section like frontend & backend
         * then make route separate route group
         *
         * @var string
         */
        'prefix' => '/',

        /*
         * --------------------------------------------------------------------
         * Authentication Medium
         * --------------------------------------------------------------------
         *
         * Authentication medium used to authentication
         *
         * @reference \Modules\Admin\Supports\Constant::class
         * @var string [email, username, mobile, otp]
         */
        'credential_field' => 'email',

        /*
         * --------------------------------------------------------------------
         * OTP Medium
         * --------------------------------------------------------------------
         *
         * OTP Confirmation Medium
         *
         * @reference \Modules\Admin\Supports\Constant::class
         * @var string [email, mobile]
         */
        'credential_otp_field' => 'mobile',

        /*
         *--------------------------------------------------------------------------
         * Allow Self-Register Route
         *--------------------------------------------------------------------------
         *
         * Here you may define if you want to allow anyone to self-register.
         * By default, the permission is set to true.
         *
         */

        'allow_register' => false,

        /*
         * --------------------------------------------------------------------
         * Allow Persistent Login Cookies (Remember me)
         * --------------------------------------------------------------------
         *
         * While every attempt has been made to create a very strong protection
         * with to remember me system, there are some cases (like when you
         * need extreme protection, like dealing with users financials) that
         * you might not want the extra risk associated with this cookie-based
         * solution.
         *
         * @var bool
         */
        'allow_remembering' => true,

        /*
         * --------------------------------------------------------------------
         * Minimum Password Length
         * --------------------------------------------------------------------
         *
         * The minimum length that a password must be to be accepted.
         * Recommended minimum value by NIST = 8 characters.
         *
         * @var int
         */
        'minimum_password_length' => 6,

        /*
         * --------------------------------------------------------------------
         * Self Password Reset
         * --------------------------------------------------------------------
         *
         * Allow user to reset his/her own password
         * If he/she has forgotten
         *
         * @var bool
         */
        'allow_password_reset' => true,
    ]
];
