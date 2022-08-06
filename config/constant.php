<?php

return [
    /**
     * System Model Status
     */
    'enabled_options' => ['yes' => 'Yes', 'no' => 'No'],

    /**
     * System Permission Title Constraint
     */
    'permission_name_allow_char' => '([a-zA-Z0-9.-_]+)',

    /**
     * Timing Constants
     */
    'second' => '1',

    'minute' => '60',

    'hour' => '3600',

    'day' => '86400',

    'week' => '604800',

    'month' => '2592000',

    'year' => '31536000',

    'decade' => '315360000', //1de=10y

    /**
     * Toastr Message Levels
     */
    'message_error' => 'error',

    'message_warning' => 'warning',

    'message_success' => 'success',

    'message_info' => 'info',

    /**
     * Authentication Login Medium
     */
    'login_email' => 'email',

    'login_username' => 'username',

    'login_mobile' => 'mobile',

    'login_otp' => 'otp',

    /**
     * OTP Medium Source
     */
    'otp_mobile' => 'mobile',

    'otp_email' => 'email',

    'export_options' => [
        'xlsx' => 'Microsoft Excel (.xlsx)',
        'ods' => 'Open Document Spreadsheet (.ods)',
        'csv' => 'Comma Separated Values (.csv)',
    ],

    /**
     * Default Role Name for system administrator
     */
    'super_admin_role' => 'Super Administrator',

    /**
     * Default Email Address for backend admin panel
     */
    'email' => 'hafijul233@gmail.com',

    /**
     * Default model enabled status
     */
    'enabled_option' => 'yes',

    /**
     * Default model disabled statusENABLED_OPTION
     */
    'disabled_option' => 'no',

    /**
     * Default Password
     */
    'password' => 'password',

    /**
     * Default profile display image is user image is missing
     */
    'user_profile_image' => 'assets/img/logo.png',

    /**
     * Default Logged User Redirect Route
     */
    'dashboard_route' => 'backend.dashboard',

    'locale' => 'en',

    /**
     * Default Exp[ort type
     */
    'export_default' => 'xlsx',
];
