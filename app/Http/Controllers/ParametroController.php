<?php

namespace App\Http\Controllers;

use App\Models\Parametro;
use App\Models\ParametroValor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Logs;
use Illuminate\Support\Facades\Log;

class ParametroController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function listar(){        
        $parametros = DB::table('parametros_valor')
                                    ->select('parametros_valor.pv_id',
                                             'parametros_valor.pv_param',
                                             'parametros_valor.pv_valor',
                                             'parametros_valor.pv_ativo',
                                             'parametros.param_id',
                                             'parametros.param_cod',
                                             'parametros.param_desc',
                                             'parametros.param_tipo')
                                        ->join('parametros', 'parametros.param_id', '=', 'parametros_valor.pv_param')
                                        ->where('parametros_valor.pv_ativo', 1)                                        
                                        ->groupBy('pv_param')
                                        ->get();  
        return view('configuracao/parametro', compact('parametros'));
    }

    public function editar($param_id){
        $parametros = DB::table('parametros_valor')
                                    ->select('parametros_valor.pv_id',
                                             'parametros_valor.pv_valor')
                                        ->join('parametros', 'parametros.param_id', '=', 'parametros_valor.pv_param')                                        
                                        ->where('parametros.param_id', $param_id)->get();
        return view('configuracao/parametro', compact('parametros'));
    }

    public function ParametroValor($param_id){
        $parametroValor = DB::table('parametros_valor')
                                    ->select('parametros_valor.pv_id',
                                             'parametros_valor.pv_param',
                                             'parametros_valor.pv_valor',
                                             'parametros.param_id',
                                             'parametros.param_cod',
                                             'parametros.param_desc',
                                             'parametros.param_tipo')
                                        ->join('parametros', 'parametros.param_id', '=', 'parametros_valor.pv_param')                                        
                                        ->where('parametros.param_id', $param_id)->get();
        return Response::json($parametroValor);
    }

    public function update(Request $request, $param_id){
        
        $parametro = ParametroValor::join('parametros', 'parametros.param_id', '=', 'parametros_valor.pv_param')
                                    ->where([['pv_id','=', $param_id]])->first();

        if(isset($request->param_valor_select)){   
            
            Logs::insert(['modulo' => 'Parâmetros'
                        , 'antes'  => $parametro->pv_valor
                        , 'depois' => $request->param_valor_select]);

            $parametro->pv_valor = $request->param_valor_select;

        }else{     

            Logs::insert(['modulo' => 'Parâmetros'
                        , 'antes'  => $parametro->pv_valor
                        , 'depois' => $request->param_valor_text]);

            $parametro->pv_valor = $request->param_valor_text;
        }

        if($parametro->save()){
            return redirect('configuracao/parametro')->with('success', 'Sucesso ao atualizar');
        }else{
            return redirect('configuracao/parametro')->with('error', 'Erro ao atualizar, verifique e tente novamente');
        }
    }

}
