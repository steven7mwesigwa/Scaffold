<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Http\Forms\UserForm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class SettingsController extends Controller
{
    /**
     * View current user's settings
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $user = auth()->user();

        $form = app(UserForm::class)->edit($user);

        $deleteAccountForm = form()
            ->confirm(trans('general.user.delete_account'))
            ->action('delete', 'user.destroy', 'Delete My Account', [
                'class' => 'btn btn-danger mt-4'
            ]);

        return view('user.settings')
            ->with('form', $form)
            ->with('deleteAccountForm', $deleteAccountForm);
    }

    /**
     * Update the user
     *
     * @param  UpdateAccountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        try {
            if ($request->avatar) {
                Storage::delete(auth()->user()->avatar);
            }

            $path = Storage::putFile('public/avatars', $request->avatar, 'public');

            auth()->user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => $path,
            ]);

            return back()->with('message', 'Settings updated successfully');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
