<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginFormRequest $request)
    {
        $validated = $request->safe()->only('email', 'password');

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();
            return redirect('/posts');
        }

        return back()
            ->withErrors([
                'email' => trans('auth.failed'), //trans = translate
                'password' => trans('auth.password'),
            ])
            ->withInput();
    }

    public function destroy()
    {
        auth()->logout();
        return redirect('/posts');
    }
}
