<?php

namespace App\Http\Controllers;

use App\Models\UltimoAcesso;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UltimoAcessoController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function listar(){
        $ultimosAcessos = UltimoAcesso::all();

        return view('configuracao.acesso', compact('ultimosAcessos'));
    }
}
