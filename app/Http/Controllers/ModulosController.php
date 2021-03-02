<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ModulosController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function cadastros(){
      return view('cadastros.modulos');
  }

  public function listar(){        
    $modulos = Modulo::all();

    return view('listar/modulos', compact('modulos'));
  }

  public function editar($modulo_id){

    $modulo = DB::table('modulos')
                    ->where('modulo_id', $modulo_id)
                    ->first();

    return view('cadastros.modulos', compact('modulo'));
  }

  public function store(Request $request){

    foreach ($request->array_item as $modulos){       
      Modulo::insert(['modulo_descricao' => $modulos]);
    }
    
    return redirect('/cadastros/modulos')->with('success', 'Sucesso ao inserir');

  }
  public function update(Request $request, $modulo_id){

    $dataForm = $request->except(['_token', '_method']);        
    $modulo = Modulo::where('modulo_id', $modulo_id);
    $update = $modulo->update($dataForm);

    if($update){
        return redirect(route('editar.modulos', $modulo_id))->with('success', 'Sucesso ao atualizar');
    }else{
        return redirect(route('editar.modulos', $modulo_id))->with('error', 'Erro ao atualizar, verifique e tente novamente');
    }
  }
}
