<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Model Definition
    |--------------------------------------------------------------------------
    |
    | Please specify a user model that should be used to setup `creator`
    | and `updater` relationship.
    |
    */

    'paginate_location' => 'layouts.paginate.',

    /*
    |--------------------------------------------------------------------------
    | User Model Definition
    |--------------------------------------------------------------------------
    |
    | Please specify a user model that should be used to setup `creator`
    | and `updater` relationship.
    |
    */

    'popup_actions' => [
        'delete' => 'core::popup.delete',
        'restore' => 'core::popup.restore',
        'export' => 'core::popup.export',
        'import' => 'core::popup.import',
    ],

    //Blameable Trait and Uses

    'blame' => [

        /*
        |--------------------------------------------------------------------------
        | User Model Definition
        |--------------------------------------------------------------------------
        |
        | Please specify a user model that should be used to setup `creator`
        | and `updater` relationship.
        |
        */

        'user' => \App\User::class,

        /*
        |--------------------------------------------------------------------------
        | The `createdBy` attribute
        |--------------------------------------------------------------------------
        |
        | Please define an attribute to use when recording the creator
        | identifier.
        |
        */

        'createdBy' => 'created_by',

        /*
        |--------------------------------------------------------------------------
        | The `updatedBy` attribute
        |--------------------------------------------------------------------------
        |
        | Please define an attribute to use when recording the updater
        | identifier.
        |
        */

        'updatedBy' => 'updated_by',

        /*
        |--------------------------------------------------------------------------
        | The `deletedBy` attribute
        |--------------------------------------------------------------------------
        |
        | Please define an attribute to use when recording the user
        | identifier who deleted the record. This feature would only work
        | if you are using SoftDeletes in your model.
        |
        */

        'deletedBy' => 'deleted_by',
    ],

    //XML Response handler
    'xml' => [
        /*
         |--------------------------------------------------------------------------
         | Default template
         |--------------------------------------------------------------------------
         |
         | Template to XML
         |
         | <root xmlns:v1="http://www.site.com/schema"></root>
         |
         */
        'template' => '<root></root>',
        'caseSensitive' => false,
        'showEmptyField' => true, //Show empty field
        'charset' => 'utf-8',
        'rowName' => null,
    ],
];
