<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use PDF;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('status', 'ativo')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,User $user)
    {

        $validated =   $request->validated();

        $user->update($validated);
        return response()->json(['message' => 'Usuário atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'inativo';
        $user->save();

        // $user->delete();

        return response()->json(null, 204);
    }

    public function allGerarPdf()
    {
        // Obter os usuários
        $usuarios = User::all();

        // Carregar a view HTML e passar os dados
        $pdf = PDF::loadView('usuarios_pdf', compact('usuarios'));

        // Retornar o PDF como resposta da API
        return $pdf->download('users.pdf');
    }

    public function gerarPdf($id)
    {
        $user = User::findOrFail($id);

        // Carrega a view 'user_pdf' e passa os dados do usuário para a view
        $pdf = PDF::loadView('usuario_pdf', compact('user'));

        // Retorna o PDF como download
        return $pdf->download("usuario_{$user->id}.pdf");
    }
}
