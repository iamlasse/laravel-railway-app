<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed $user
     * @param  array $input
     * @return void
     */
    public function update($user, array $input)
    {
        
        $validated = Validator::make(
            $input,
            [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'numeric'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
            ]
        )->validateWithBag('updateProfileInformation');
        
        if (isset($validated['photo'])) {
            $user->updateProfilePhoto($validated['photo']);
        }

        if (
            $validated['email'] !== $user->email
            && $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill(
                [
                'name' => $validated['name'],
                'email' => $validated['email'],
                ]
            )->save();

            if($user instanceof Admin) {
                if($validated['phone'] != $user->phone) {
                    $user->forceFill([
                        'phone' => $validated['phone']
                    ])->save();
                }
            }
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed $user
     * @param  array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill(
            [
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            ]
        )->save();

        $user->sendEmailVerificationNotification();
    }
}
