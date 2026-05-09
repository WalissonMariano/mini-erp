<?php

namespace App\Http\Controllers\Cadastro;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Cadastro\Usuarios;
use App\Models\Cadastro\Grupos;
use App\Models\Cadastro\Empresa;

class UsuariosController extends Controller
{
    //Busca de todos os usuários
    public function index()
    {
        $usuarios = Usuarios::with(['empresa:id,str_razao_social', 'grupo:id,str_nome'])->get();
        return view('cadastro/usuarios/index_usuarios', compact('usuarios'));
    }

    //Busca de um usuário pelo ID para edição
    public function edit($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $empresa = Empresa::findOrFail($usuario->empresa_id);
        $grupo = Grupos::findOrFail($usuario->grupo_id);
        return view('cadastro/usuarios/form_usuarios', compact('usuario', 'empresa', 'grupo'));
    }

    //Exibição do formulário de cadastro de usuário
    public function create()
    {
        $empresas = Empresa::orderBy('str_razao_social')->get();
        $grupos = Grupos::orderBy('str_nome')->get();
        return view('cadastro/usuarios/form_usuarios', compact('empresas', 'grupos'));
    }

    //Salva dados de um novo usuário
    public function store(Request $request)
    {
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_email' => 'required|email|max:120|unique:usuarios,str_email',
            'str_password' => 'required|string|min:6',
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'grupo_id' => 'required|uuid|exists:grupos,id',
            'is_active' => 'required|boolean',
        ]);
        
        $validated['str_password'] = bcrypt($validated['str_password']);

        Usuarios::create($validated);
        return redirect()->route('pagina.lista.usuarios')->with('success', 'Usuário criado com sucesso!');
    }

    //Atualiza um usuário pelo ID
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'str_nome' => 'required|string|max:150',
            'str_email' => 'required|email|max:120|unique:usuarios,str_email,' . $id . ',id',
            'str_password' => 'nullable|string|min:6',
            'empresa_id' => 'required|uuid|exists:empresa,id',
            'grupo_id' => 'required|uuid|exists:grupos,id',
            'is_active' => 'required|boolean',
        ]);

        if (empty($validated['str_password'])) {
            unset($validated['str_password']);
        } else {
            $validated['str_password'] = bcrypt($validated['str_password']);
        }

        $usuario = Usuarios::findOrFail($id);
        $usuario->update($validated);
        return redirect()->route('pagina.lista.usuarios')->with('success', 'Usuário atualizado com sucesso!');
    }

    //Exclui um usuário pelo ID
    public function destroy($id)
    {        
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();
        return redirect()->route('pagina.lista.usuarios')->with('success', 'Usuário excluído com sucesso!');
    }

}
