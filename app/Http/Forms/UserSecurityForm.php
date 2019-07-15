<?php

namespace App\Http\Forms;

use Grafite\FormMaker\Fields\Password;
use Grafite\FormMaker\Forms\BaseForm;

class UserSecurityForm extends BaseForm
{
    public $route = 'user.security';

    public $method = 'put';

    public $orientation = 'horizontal';

    public $buttons = [
        'save' => 'Save',
    ];

    public $columns = 1;

    public function fields()
    {
        return [
            Password::make('old_password', [
                'required' => true,
                'label' => 'Old Password'
            ]),
            Password::make('new_password', [
                'required' => true,
                'label' => 'New Password'
            ]),
            Password::make('new_password_confirmation', [
                'required' => true,
                'label' => 'Confirm New Password'
            ]),
        ];
    }
}
