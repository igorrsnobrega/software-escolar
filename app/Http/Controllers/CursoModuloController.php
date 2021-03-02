<?php

namespace App\Http\Controllers;
use App\Models\Curso;
use App\Models\Modulo;
use App\Models\CursoModulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CursoModuloController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function cursosModulos(){    
        
        $modulos = Modulo::all();
        $cursos = Curso::all();

        return view('vinculos/cursos-modulos', compact('cursos', 'modulos'));
    }

    public function CursosModulosVinculados($curso_id){
        $CursoModulosVinculados = DB::table('cursos_modulos')
                                        ->select('controle_id'
                                            , 'cursos.curso_id'
                                            , 'modulos.modulo_id'
                                            , 'modulos.modulo_descricao')
                                        ->join('modulos', 'modulos.modulo_id', '=', 'cursos_modulos.modulo_id')
                                        ->join('cursos', 'cursos.curso_id', '=', 'cursos_modulos.curso_id')
                                        ->where('cursos.curso_id', $curso_id)->get();

        return Response::json($CursoModulosVinculados);
    }

    public function store(Request $request){

        foreach($request->array_item as $modulo){
            CursoModulo::insert(['curso_id' => $request->curso_id, 'modulo_id' => $modulo]);
        }
        return redirect('/vinculos/cursos-modulos')->with('success', 'Sucesso ao vincular');
    }

}
