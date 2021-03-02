<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Curso;

class CursosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function cadastros(){
        return view('cadastros.cursos');
    }

    public function listar(){
        $cursos = DB::select("SELECT curso_nome_curso
                                   , curso_id
                                   , curso_cargaHoraria
                                   , CASE 
                                        WHEN curso_ativo = 1 THEN
                                           'Ativo'
                                        ELSE
                                           'Inativo'
                                     END curso_ativo 
                                FROM cursos");

        return view('listar.cursos', compact('cursos'));
    }

    public function store(Request $request){

        $curso = new Curso();

        $curso->curso_nome_curso   = $request->curso_nome_curso;
        $curso->curso_cargaHoraria = $request->curso_cargaHoraria;
        $curso->curso_frase        = $request->curso_frase;
        $curso->curso_pq           = $request->curso_pq;
        $curso->curso_quem         = $request->curso_quem;
        $curso->curso_recompensa   = $request->curso_recompensa;

        //tratando imagem
        if($request->hasFile('imagemCurso') && $request->file('imagemCurso')->isValid()){
            $imagem = $request->imagemCurso;
            $extensao = $imagem->getClientOriginalExtension();
            $imagemNome = md5($imagem->getClientOriginalName().strtotime("now")) .'.'. $extensao;
            $imagem->move(public_path('img/cursos'), $imagemNome);

            $curso->imagemCurso1 = $imagemNome;
        }

        if($curso->save()){
            return redirect('/cadastros/cursos')->with('success', 'Sucesso ao inserir');
        }else{
            return redirect('/cadastros/cursos')->with('error', 'Erro ao inserir, verifique e tente novamente');
        }        
    }

    public function editar($curso_id){

        $curso = DB::table('cursos')
                        ->where('curso_id', $curso_id)
                        ->first();

        return view('cadastros.cursos', compact('curso'));
    }

    public function update(Request $request, $curso_id){
     
        $curso = Curso::where('curso_id', '=', $curso_id)->first();

        $curso->curso_nome_curso   = $request->curso_nome_curso;
        $curso->curso_cargaHoraria = $request->curso_cargaHoraria;
        $curso->curso_frase        = $request->curso_frase;
        $curso->curso_pq           = $request->curso_pq;
        $curso->curso_quem         = $request->curso_quem;
        $curso->curso_recompensa   = $request->curso_recompensa;

        //tratando imagem
        if($request->hasFile('imagemCurso1') && $request->file('imagemCurso1')->isValid()){
            $imagem = $request->imagemCurso1;
            $extensao = $imagem->getClientOriginalExtension();
            $imagemNome = md5($imagem->getClientOriginalName().strtotime("now")) .'.'. $extensao;
            $imagem->move(public_path('img/cursos'), $imagemNome);
            $curso->imagemCurso1 = $imagemNome;
        }

        if($curso->save()){
            return redirect(route('editar.cursos', $curso_id))->with('success', 'Sucesso ao atualizar');
        }else{
            return redirect(route('editar.cursos', $curso_id))->with('error', 'Erro ao atualizar, verifique e tente novamente');
        }
    }
}
