<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\AlunoCurso;
use App\Models\Curso;
use App\Models\Contrato;
use App\Models\Parcela;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ContratoController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function gerar(){
            $alunos = Aluno::all();
            $cursos = Curso::all(); 
        
        return view('/gerar/contrato', compact('alunos', 'cursos'));
    }

    public function listar(){
        $contratos = DB::table('contratos')
                            ->select('*')
                            ->join('alunos', 'alunos.aluno_id', '=', 'contratos.cont_aluno')
                            ->join('cursos', 'cursos.curso_id', '=', 'contratos.cont_curso')
                            ->leftJoin('alunos_cursos', 'alunos_cursos.aluno_contrato', '=', 'contratos.cont_id')
                            ->get();

        return view('/listar/contratos', compact('contratos'));
    }

    public function editar($contrato_id){
        $contratos = DB::table('contratos')
                            ->select('*')
                            ->join('alunos', 'alunos.aluno_id', '=', 'contratos.cont_aluno')
                            ->join('cursos', 'cursos.curso_id', '=', 'contratos.cont_curso')
                            ->leftJoin('alunos_cursos', 'alunos_cursos.aluno_contrato', '=', 'contratos.cont_id')
                            ->where('cont_id', $contrato_id)
                            ->first();

        $alunos = Aluno::all();
        $cursos = Curso::all();

        return view('/gerar/contrato', compact('contratos', 'alunos', 'cursos'));
    }

    public function update(Request $request, $cont_id){

        $contrato = Contrato::where('cont_id', '=', $cont_id)->first();

        if(($request->cont_qtdParcela < $contrato->cont_n_parcela) OR ($request->cont_qtdParcela > $contrato->cont_n_parcela)){
            
            Parcela::where('contrato_id', $cont_id)->delete();

            for ($x = 1; $x <= $request->cont_qtdParcela; $x++){

                Parcela::insert(['contrato_id'      => $cont_id
                               , 'num_parcela'      => $x
                               , 'valor_parcela'    => str_replace(',','.', $request->cont_valor_parcelas)
                               , 'status_pagamento' => 1]);
            }
        }

        $contrato->cont_aluno                 = $request->aluno_id;
        $contrato->cont_data_entrada          = $request->cont_data_entrada;
        $contrato->cont_curso                 = $request->curso_id;
        $contrato->cont_data_vencimento       = $request->cont_data_vencimento;
        $contrato->cont_status_pagamento      = 1;
        $contrato->cont_n_parcela             = $request->cont_qtdParcela;
        $contrato->cont_valor_parcelas        = str_replace(',','.', $request->cont_valor_parcelas);
        $contrato->cont_valor_entrada         = str_replace(',','.', $request->cont_valor_entrada);
        $contrato->cont_valor_integral        = str_replace(',','.', $request->cont_valor_integral);
        $contrato->cont_valor_desconto        = str_replace(',','.', $request->cont_valor_desconto);
        $contrato->cont_vDesconto             = str_replace(',','.', $request->cont_vDesconto);
        $contrato->cont_valor_final           = str_replace(',','.', $request->cont_valor_final);
        $contrato->cont_material              = str_replace(',','.', $request->cont_material);
        $contrato->cont_matricula             = str_replace(',','.', $request->cont_matricula);
        $contrato->cont_fomraPagamento        = $request->cont_fomraPagamento;
        $contrato->cont_dataPrimeiroPagamento = $request->cont_dataPrimeiroPagamento;
        $contrato->cont_status_contrato       = 1;
        $contrato->cont_observacoes           = $request->cont_observacoes;
        $contrato->cont_n_parcela             = $request->cont_qtdParcela;

        if($contrato->save()){
            return redirect(route('gerar.contrato'))->with('success', 'Sucesso ao atualizar');
        }else{
            return redirect(route('gerar.contrato'))->with('error', 'Erro ao atualizar, verifique e tente novamente');
        }
    } 

    public function alunosCursosContratos($aluno_id){
        $alunoCursoContrato = DB::table('alunos_cursos')
                                ->select('controle_id'
                                       , 'alunos.aluno_id'
                                       , 'cursos.curso_id'
                                       , 'cursos.curso_nome_curso')
                                ->join('alunos', 'alunos.aluno_id', '=', 'alunos_cursos.aluno_id')
                                ->join('cursos', 'cursos.curso_id', '=', 'alunos_cursos.curso_id')                                
                                ->where([['alunos.aluno_id','=', $aluno_id], ['alunos_cursos.aluno_contrato','=', null]])->get();

        return Response::json($alunoCursoContrato);
    }

    public function formataDataParcelas($data, $opcao, $contador){
        $frequency = ['DAY', 'MONTH', 'YEAR'];
        return $data = date("Y/m/d", strtotime($data. "+".$contador." ".$frequency[$opcao]));

    }

    public function getContrato($contrato_id){
        return Contrato::find($contrato_id);
    }


    public function store(Request $request){
        $contrato = new Contrato();    

        $contrato->cont_aluno                 = $request->aluno_id;
        $contrato->cont_data_entrada          = $request->cont_data_entrada;
        $contrato->cont_curso                 = $request->curso_id;
        $contrato->cont_data_vencimento       = $request->cont_data_vencimento;
        $contrato->cont_status_pagamento      = 1;
        $contrato->cont_n_parcela             = $request->cont_qtdParcela;
        $contrato->cont_valor_parcelas        = str_replace(',','.', $request->cont_valor_parcelas);
        $contrato->cont_valor_entrada         = str_replace(',','.', $request->cont_valor_entrada);
        $contrato->cont_valor_integral        = str_replace(',','.', $request->cont_valor_integral);
        $contrato->cont_valor_desconto        = str_replace(',','.', $request->cont_valor_desconto);
        $contrato->cont_vDesconto             = str_replace(',','.', $request->cont_vDesconto);
        $contrato->cont_valor_final           = str_replace(',','.', $request->cont_valor_final);
        $contrato->cont_material              = str_replace(',','.', $request->cont_material);
        $contrato->cont_matricula             = str_replace(',','.', $request->cont_matricula);
        $contrato->cont_fomraPagamento        = $request->cont_fomraPagamento;
        $contrato->cont_dataPrimeiroPagamento = $request->cont_dataPrimeiroPagamento;
        $contrato->cont_status_contrato       = 1;
        $contrato->cont_observacoes           = $request->cont_observacoes;
        $contrato->cont_n_parcela             = $request->cont_qtdParcela;

        if($contrato->save()){

            for ($x = 1; $x <= $request->cont_qtdParcela; $x++){

                Parcela::insert(['contrato_id'      => $contrato->cont_id
                               , 'num_parcela'      => $x
                               , 'valor_parcela'    => str_replace(',','.', $request->cont_valor_parcelas)
                               , 'status_pagamento' => 1]);
            }

            AlunoCurso::where([['aluno_id', $contrato->cont_aluno]
                             , ['curso_id', $contrato->cont_curso]
                             , ['controle_id', $contrato->controle_id]])
                        ->update(['aluno_contrato' => $contrato->cont_id]);

            return redirect('/gerar/contrato')->with('success', 'Contrato '.$contrato->cont_id.' gerado com sucesso!');
        }else{
            return redirect('/gerar/contrato')->with('error', 'Erro ao gerar o contrato');
        }
    }
}
