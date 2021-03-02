<?php

namespace App\Http\Controllers;
use App\Models\Modulo;
use App\Models\Equipamento;
use App\Models\ModuloEquipamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ModuloEquipamentoController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function modulosEquipamentos(){    
        
        $modulos = Modulo::all();
        $equipamentos = Equipamento::all();

        return view('vinculos/modulos-equipamentos', compact('modulos', 'equipamentos'));
    }

    public function ModulosEquipamentosVinculados($modulo_id){
        $ModulosEquipVinculados = DB::table('modulos_equip')
                                        ->select('controle_id'
                                            , 'modulos.modulo_id'
                                            , 'equipamentos.equip_id'
                                            , 'equipamentos.equip_desc')
                                        ->join('modulos', 'modulos.modulo_id', '=', 'modulos_equip.modulo_id')
                                        ->join('equipamentos', 'equipamentos.equip_id', '=', 'modulos_equip.equip_id')
                                        ->where('modulos.modulo_id', $modulo_id)->get();

        return Response::json($ModulosEquipVinculados);
    }

    public function store(Request $request){

        foreach($request->array_item as $equipamento){
            ModuloEquipamento::insert(['modulo_id' => $request->modulo_id, 'equip_id' => $equipamento]);
        }
        return redirect('/vinculos/modulos-equipamentos')->with('success', 'Sucesso ao vincular');
    }
}
