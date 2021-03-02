<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceiroController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function caixa(){
        return view('/financeiro/caixa');
    }
}
