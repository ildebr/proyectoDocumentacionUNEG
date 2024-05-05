<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return view('auth.register')->with('roles', $roles);    
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'cedula' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        error_log($request->cedula);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'segundo_nombre'=> $request->segundo_nombre,
            'primer_apellido'=> $request->primer_apellido,
            'segundo_apellido'=> $request->segundo_apellido,
            'cedula'=> $request->cedula,
            'password' => Hash::make($request->password),
        ]);
        if($request->rol){
            $user->assignRole($request->rol);
        }
        

        event(new Registered($user));

        //Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
