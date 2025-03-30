<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prato;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public readonly Prato $prato;
    public function __construct()
    {
        $this->prato = new Prato;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $pratos = Prato::paginate(5);
        return view('pages.admin.cardapio.index', compact('pratos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('pages.admin.cardapio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria' => 'required|in:Entradas,Prato principal,Sobremesas,Cardapio infantil,Bebidas',
        ]);

        $created = $this->prato->create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria
        ]);

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('pratos', 'public');
            $created->imagem = $path;
            $created->save();
        }

        return redirect()->route('admin.cardapio.index')->with('success', 'Prato adicionado!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prato $prato) : View
    {
        return view('pages.admin.cardapio.edit', compact('prato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id) : RedirectResponse
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria' => 'required|in:Entradas,Prato principal,Sobremesas,Cardapio infantil,Bebidas',
        ]);

        $prato = $this->prato->find($id);

        $updated = $prato->update($request->except('_token', '_method', 'imagem'));

        if ($request->hasFile('imagem')) {
            $path = $request->file('imagem')->store('pratos', 'public');
            $prato->imagem = $path;
            $prato->save();
        }

        if(!$updated) {
            return redirect()->back()->with('error', 'Erro ao atualizar prato');
        }

        return redirect()->route('admin.cardapio.index')->with('success', 'Prato atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prato $prato) : RedirectResponse
    {
        $prato->delete();
        return redirect()->route('admin.cardapio.index')->with('success', 'Prato removido!');
    }

}
