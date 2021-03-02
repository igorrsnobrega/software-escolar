<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function dadosDashboard(){
        $novosAlunosMesPassado = DB::select("SELECT count(t.aluno_id) AS novos_aluno_mes_passado
                                               FROM alunos t
                                              WHERE date_insert BETWEEN (ADDDATE(LAST_DAY(SUBDATE(DATE_SUB(curdate(), INTERVAL 1 MONTH), INTERVAL 1 MONTH)), 1)) 
                                                AND (last_day(DATE_SUB(curdate(), INTERVAL 1 MONTH)))");

        $novosAlunos = DB::select("SELECT count(t.aluno_id) AS novos_aluno_mes
                                     FROM alunos t
                                    WHERE date_insert BETWEEN (SELECT ADDDATE(LAST_DAY(SUBDATE(CURDATE(), INTERVAL 1 MONTH)), 1)) 
                                      AND (select last_day(sysdate()) FROM dual)");

        $periodo = DB::select("SELECT ADDDATE(LAST_DAY(SUBDATE(CURDATE(), INTERVAL 1 MONTH)), 1) primeiro_dia, 
                                      last_day(sysdate()) ultimo_dia,
                                      ADDDATE(LAST_DAY(SUBDATE(DATE_SUB(curdate(), INTERVAL 1 MONTH), INTERVAL 1 MONTH)), 1) primeiro_dia_mes_passado, 
                                      last_day(DATE_SUB(curdate(), INTERVAL 1 MONTH)) ultimo_dia_mes_passado");

        $cursosMaisProcurados = DB::select("SELECT c.curso_nome_curso 
                                        FROM alunos t
                                       INNER JOIN alunos_cursos ac 
                                          ON ac.aluno_id = t.aluno_id 
                                       INNER JOIN cursos c
                                          ON c.curso_id  = ac.curso_id 
                                       WHERE ac.date_insert BETWEEN (SELECT ADDDATE(LAST_DAY(SUBDATE(CURDATE(), INTERVAL 1 MONTH)), 1)) 
                                         AND (select last_day(sysdate()))
                                       GROUP BY c.curso_id 
                                      HAVING count(ac.curso_id) > 3");

        return view('index', compact('novosAlunosMesPassado','novosAlunos', 'periodo', 'cursosMaisProcurados'));
    }
}
