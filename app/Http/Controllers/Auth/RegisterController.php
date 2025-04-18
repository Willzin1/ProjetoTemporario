<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public readonly User $user;
    public function __construct()
    {
        $this->user = new User;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'password' => 'required|min:6|max:20|confirmed'
        ], [
            'name.required' => 'Campo nome é obrigatório',
            'email.required' => 'Campo e-mail é obrigatório',
            'email.email' => 'Informe um e-mail válido',
            'email.unique' => 'E-mail já cadastrado',
            'phone' => 'Campo telefone é obrigatório',
            'password.required' => 'Campo senha é obrigatório',
            'password.min' => 'Senha deve conter no mínimo :min caracteres',
            'password.max' => 'Senha deve conter no máximo :max caracteres',
            'password.confirmed' => 'Senhas não coincidem'
        ]);

        $created = $this->user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT),
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'user',
        ]);

        if(!$created) {
            return redirect()->back()->with('error', 'Erro ao criar usuário.');
        }

        return redirect()->route('login')->with('success', 'Sucesso ao criar conta');
    }
}
