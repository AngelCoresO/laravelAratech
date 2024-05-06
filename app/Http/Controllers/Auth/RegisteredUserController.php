<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Fichero;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        if($request->hasFile('avatar') && $request->file('avatar') ){
            $uploadedFile = $request->file('avatar');
            $fileName = $uploadedFile->getClientOriginalName();
            $path = Storage::putFileAs('public/avatars', $uploadedFile, $fileName);
        }

        $user = User::create([
            'name' => $request->name,
            'lastname' =>$request->lastname,
            'direccion' =>$request->direccion,
            'ciudad' =>$request->ciudad,
            'pais' =>$request->pais,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' =>$request->telefono,
            'codigoPostal' =>$request->codigoPostal,
            'nacimiento' =>$request->nacimiento,
            'genero' =>$request->genero,
            'avatar'=>$fileName??null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }
}
