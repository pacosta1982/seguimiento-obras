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

    'questionnaire' => [
        'title' => 'Questionnaires',

        'actions' => [
            'index' => 'Questionnaires',
            'create' => 'New Questionnaire',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            
        ],
    ],

    'question' => [
        'title' => 'Questions',

        'actions' => [
            'index' => 'Questions',
            'create' => 'New Question',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'questionnaire_id' => 'Questionnaire',
            'name' => 'Name',
            'description' => 'Description',
            
        ],
    ],

    'project-question' => [
        'title' => 'Project Question',

        'actions' => [
            'index' => 'Project Question',
            'create' => 'New Project Question',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'questionnaire_id' => 'Questionnaire',
            'project_id' => 'Project',
            
        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'password' => 'Password',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];