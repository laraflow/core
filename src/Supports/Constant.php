<?php

namespace Laraflow\Core\Supports;

/**
 * Class Constant
 */
class Constant
{
    /**
     * System Model Status
     */
    public const ENABLED_OPTIONS = ['yes' => 'Yes', 'no' => 'No'];

    /**
     * System Permission Title Constraint
     */
    public const PERMISSION_NAME_ALLOW_CHAR = '([a-zA-Z0-9.-_]+)';

    /**
     * Timing Constants
     */
    public const SECOND = '1';

    public const MINUTE = '60';

    public const HOUR = '3600';

    public const DAY = '86400';

    public const WEEK = '604800';

    public const MONTH = '2592000';

    public const YEAR = '31536000';

    public const DECADE = '315360000'; //1de=10y

    /**
     * Toastr Message Levels
     */
    public const MESSAGE_ERROR = 'error';

    public const MESSAGE_WARNING = 'warning';

    public const MESSAGE_SUCCESS = 'success';

    public const MESSAGE_INFO = 'info';

    /**
     * Authentication Login Medium
     */
    public const LOGIN_EMAIL = 'email';

    public const LOGIN_USERNAME = 'username';

    public const LOGIN_MOBILE = 'mobile';

    public const LOGIN_OTP = 'otp';

    /**
     * OTP Medium Source
     */
    public const OTP_MOBILE = 'mobile';

    public const OTP_EMAIL = 'email';

    public const EXPORT_OPTIONS = [
        'xlsx' => 'Microsoft Excel (.xlsx)',
        'ods' => 'Open Document Spreadsheet (.ods)',
        'csv' => 'Comma Separated Values (.csv)',
    ];

    /**
     * Default Role Name for system administrator
     */
    public const SUPER_ADMIN_ROLE = 'Super Administrator';

    /**
     * Default Email Address for backend admin panel
     */
    public const EMAIL = 'hafijul233@gmail.com';

    /**
     * Default model enabled status
     */
    public const ENABLED_OPTION = 'yes';

    /**
     * Default model disabled statusENABLED_OPTION
     */
    public const DISABLED_OPTION = 'no';

    /**
     * Default Password
     */
    public const PASSWORD = 'password';

    /**
     * Default profile display image is user image is missing
     */
    public const USER_PROFILE_IMAGE = 'assets/img/logo.png';

    /**
     * Default Logged User Redirect Route
     */
    public const DASHBOARD_ROUTE = 'backend.dashboard';

    public const LOCALE = 'en';

    /**
     * Default Exp[ort type
     */
    public const EXPORT_DEFAULT = 'xlsx';
}
