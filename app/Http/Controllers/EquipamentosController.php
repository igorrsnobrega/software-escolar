<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamento;
use Illuminate\Support\Facades\DB;

class EquipamentosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function cadastros(){
        return view('cadastros.equipamentos');
    }

    public function listar(){        
      $equipamentos = Equipamento::all();

      return view('listar/equipamentos', compact('equipamentos'));
    }

    public function editar($equip_id){

      $equipamento = DB::table('equipamentos')
                            ->where('equip_id', $equip_id)
                            ->first();

      return view('cadastros.equipamentos', compact('equipamento'));
    }

    public function update(Request $request, $equip_id){

      $dataForm = $request->except(['_token', '_method']);        
      $equipamento = Equipamento::where('equip_id', $equip_id);
      $update = $equipamento->update($dataForm);

      if($update){
          return redirect(route('editar.equipamentos', $equip_id))->with('success', 'Sucesso ao atualizar');
      }else{
          return redirect(route('editar.equipamentos', $equip_id))->with('error', 'Erro ao atualizar, verifique e tente novamente');
      }
    }
    
    public function store(Request $request){

      foreach ($request->array_item as $equipamentos){
       
        Equipamento::insert(['equip_desc' => $equipamentos]);
      }
      
      return redirect('/cadastros/equipamentos')->with('success', 'Sucesso ao inserir');

    }
}
