<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Notifications\EmailLinkNotification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Login extends Component
{
    /**
     * @var string
     */
    public $email = null;

    /**
     * @var string
     */
    public $password = '';

    /**
     * @var bool
     */
    public $remember = false;

    public $phone = null;
    public $usePhone = false;

    public function rules()
    {
        $rules = [
            'email' => ['required', 'email', 'exists:users,email'],
        ];

        if ($this->usePhone) {
            $rules['phone'] = ['required', 'digits:10', 'exists:users,phone'];
            unset($rules['email']);
        }

        return $rules;
    }

    public function authenticate()
    {

        dd('Here');
        $this->validate();
        // if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
        //     $this->addError('email', trans('auth.failed'));

        //     return;
        // }

        $user = User::query()
            ->when(
                !is_null($this->email),
                function (Builder $query) {
                    return $query->whereEmail($this->email);
                }
            )
            ->when(
                !is_null($this->phone),
                function (Builder $query) {
                    return $query->wherePhone($this->phone);
                }
            )
            ->firstOrFail();
        // $generator = new LoginUrl($user);
        // $generator->setRedirectUrl('/dashboard'); // Override the default url to redirect to after login
        // $url = $generator->generate();

        $url = $user->generateLoginUrl();


        //OR Use a Facade
        // $url = PasswordlessLogin::forUser($user)->generate();

        $user->notify(new EmailLinkNotification($url));

        $this->reset();

        return redirect()->back()->with('message', 'Link Generated');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
