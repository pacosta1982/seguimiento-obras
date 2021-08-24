<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'visit' => [
        'title' => 'Visits',

        'actions' => [
            'index' => 'Visits',
            'create' => 'New Visit',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'project_id' => 'Project',
            'visit_number' => 'Visit number',
            'advance' => 'Advance',
            'visit_date' => 'Visit date',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];