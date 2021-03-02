<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use Illuminate\Support\Facades\DB;

class AlunosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    
    public function cadastros(){
        return view('cadastros.alunos');
    }
    
    public function listar(){        
        $alunos = Aluno::all();

        return view('listar/alunos', compact('alunos'));
    }

    public function store(Request $request){
        $aluno = new Aluno();

        $aluno->aluno_nome     = $request->aluno_nome;
        $aluno->aluno_tel      = $request->aluno_tel;
        $aluno->aluno_cel      = $request->aluno_cel;
        $aluno->aluno_email    = $request->aluno_email;
        $aluno->aluno_rg       = $request->aluno_rg;
        $aluno->aluno_cpf      = $request->aluno_cpf;
        $aluno->aluno_nasc     = $request->aluno_nasc;
        $aluno->aluno_cep      = $request->aluno_cep;
        $aluno->aluno_end      = $request->aluno_end;
        $aluno->aluno_num_casa = $request->aluno_num_casa;
        $aluno->aluno_bairro   = $request->aluno_bairro;
        $aluno->aluno_cidade   = $request->aluno_cidade;
        $aluno->aluno_estado   = $request->aluno_estado;
        $aluno->aluno_rg_resp  = $request->aluno_rg_resp;
        $aluno->aluno_cpf_resp = $request->aluno_cpf_resp;
        $aluno->aluno_resp     = $request->aluno_resp;
        $aluno->aluno_obs      = $request->aluno_obs;

        if($aluno->save()){
            return redirect('/cadastros/alunos')->with('success', 'Sucesso ao inserir');
        }else{
            return redirect('/cadastros/alunos')->with('error', 'Erro ao inserir, verifique e tente novamente');
        }
    }

    public function editar($aluno_id){

        $aluno = DB::table('alunos')
                        ->where('aluno_id', $aluno_id)
                        ->first();

        return view('cadastros.alunos', compact('aluno'));
    }

    public function update(Request $request, $aluno_id){

        $dataForm = $request->except(['_token', '_method']);        
        $aluno = Aluno::where('aluno_id', $aluno_id);
        $update = $aluno->update($dataForm);

        if($update){
            return redirect(route('editar.alunos', $aluno_id))->with('success', 'Sucesso ao atualizar');
        }else{
            return redirect(route('editar.alunos', $aluno_id))->with('error', 'Erro ao atualizar, verifique e tente novamente');
        }
    }

    public function show($aluno_id){        
        $aluno = Aluno::where('aluno_id', $aluno_id)->first();

        return view('dados/alunos', compact('aluno'));
    }

}
