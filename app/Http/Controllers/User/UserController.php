<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public readonly User $user;
    public function __construct()
    {
        $this->user = new User();
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
        ]);

        if(!$created) {
            return redirect()->back()->with('message', 'Erro ao criar usuário.');
        }

        return redirect()->back()->with('message', 'Sucesso ao criar conta');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : View
    {

        $user = $this->user->find($id);
        return view('pages.users.dashboard', ['user' => $user, 'reservas' => $user->reservas]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : View
    {

        $user = $this->user->find($id);
        return view('pages.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : RedirectResponse
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ], [
            'name.required' => 'Campo nome é obrigatório.',
            'phone.required' => 'Campo telefone é obrigatório.'
        ]);

        $updated = $this->user->where('id', $id)->update($request->except('_token', '_method'));

        if (!$updated) {
            return redirect()->back()->with('message', 'Erro ao editar informações.');
        }

        $user = $this->user->find($id);

        return redirect()->route('users.show', ['user' => $user->id])->with('success', 'Informações alteradas com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : RedirectResponse
    {

        $this->user->where('id', $id)->delete();
        return redirect()->route('login')->with('success', 'Usuário deletado com sucesso.');
    }
}
