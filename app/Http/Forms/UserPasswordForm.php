<?php

namespace App\Http\Forms;

use Grafite\Forms\Forms\BaseForm;
use Grafite\Forms\Fields\Password;

class UserPasswordForm extends BaseForm
{
    public $route = 'user.settings.password.update';

    public $method = 'put';

    public $buttons = [
        'submit' => 'Save',
    ];

    public $columns = 1;

    public function fields()
    {
        return [
            Password::make('old_password', [
                'required' => true,
                'label' => 'Current Password',
            ]),
            Password::make('new_password', [
                'required' => true,
                'label' => 'New Password',
            ]),
            Password::make('new_password_confirmation', [
                'required' => true,
                'label' => 'Confirm New Password',
            ]),
        ];
    }
}
