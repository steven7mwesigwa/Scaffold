<?php

namespace App\Http\Forms;

use App\Models\User;
use Grafite\Forms\Html\HrTag;
use Grafite\Forms\Fields\Text;
use Grafite\Forms\Fields\Email;
use Grafite\Forms\Html\Heading;
use Grafite\Forms\Fields\Toggled;
use Grafite\Forms\Forms\ModelForm;
use Grafite\Forms\Fields\FileWithPreview;
use Grafite\Forms\Fields\Bootstrap\Select;

class UserForm extends ModelForm
{
    public $model = User::class;

    public $routePrefix = 'user';

    public $withJsValidation = true;

    public $withLivewire = false;

    public $livewireOnKeydown = false;

    public $buttons = [
        'submit' => 'Save',
        'delete' => '<span class="fas fa-fw fa-trash"></span> Delete',
    ];

    public $columns = 1;

    public $orientation = 'horizontal';

    public $hasFiles = true;

    public function fields()
    {
        return array_merge([
            Text::make('name', [
                'required' => true,
            ]),
            Email::make('email', [
                'required' => true,
            ]),
            Toggled::make('dark_mode', [
                'legend' => 'Dark Mode',
                'theme' => (auth()->user()->dark_mode) ? 'dark' : 'light',
                'color' => '#8558da',
            ]),
            Toggled::make('allow_email_based_notifications', [
                'legend' => 'Email Contact',
                'color' => '#8558da',
            ]),
            FileWithPreview::make('avatar', [
                'preview_identifier' => '.avatar',
                'preview_as_background_image' => true,
            ]),
            Select::make('two_factor_platform', [
                'multiple' => false,
                'null_value' => true,
                'label' => 'Two Factor Platform',
                'options' => [
                    'Email' => 'email',
                    'Authenticator' => 'authenticator',
                ],
                'value' => auth()->user()->two_factor_platform,
            ]),
        ], $this->billingColumns());
    }

    public function billingColumns()
    {
        return [
            Heading::make([
                'class' => 'mt-4 mb-1',
                'content' => 'Billing Details',
                'level' => 4,
            ]),
            HrTag::make(),
            Email::make('billing_email', [
                'label' => 'Email',
                'required' => auth()->user()->hasActiveSubscription(),
            ]),
            Text::make('state', [
                'label' => 'State',
                'required' => auth()->user()->hasActiveSubscription(),
            ]),
            Text::make('country', [
                'label' => 'Country',
                'required' => auth()->user()->hasActiveSubscription(),
            ]),
        ];
    }
}
