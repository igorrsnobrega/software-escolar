<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CursosController;
use App\Http\Controllers\AlunosController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\EquipamentosController;
use App\Http\Controllers\AlunoCursoController;
use App\Http\Controllers\CursoModuloController;
use App\Http\Controllers\ModuloEquipamentoController;
use App\http\Controllers\UltimoAcessoController;
use App\Http\Controllers\ParametroController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\FinanceiroController;

Auth::routes();

//index
Route::get('/', 'IndexController@dadosDashboard')->name('home');
Route::get('/index', 'IndexController@dadosDashboard')->name('index');
Route::get('/layouts/localizar', 'LocalizarController@index')->name('layouts.localizar');

//aluno
Route::get('/cadastros/alunos',                          [AlunosController::class, 'cadastros'])->name('cadastros.alunos');
Route::get('/listar/alunos',                             [AlunosController::class, 'listar'])->name('listar.alunos');
Route::post('/cadastros/alunos',                         [AlunosController::class, 'store'])->name('alunos.store');
Route::get('/cadastros/alunos/{aluno_id}/editar',        [AlunosController::class, 'editar'])->name('editar.alunos');
Route::put('/cadastros/alunos/{aluno_id}',               [AlunosController::class, 'update'])->name('alunos.update');
Route::get('/dados/alunos/{aluno_id}',                   [AlunosController::class, 'show'])->name('alunos.show');
//cursos
Route::get('/cadastros/cursos',                          [CursosController::class,'cadastros'])->name('cadastros.cursos');
Route::get('/listar/cursos',                             [CursosController::class,'listar'])->name('listar.cursos');
Route::post('/cadastros/cursos',                         [CursosController::class, 'store'])->name('cursos.store');
Route::get('/cadastros/cursos/{curso_id}/editar',        [CursosController::class, 'editar'])->name('editar.cursos');
Route::put('/cadastros/cursos/{curso_id}',               [CursosController::class, 'update'])->name('cursos.update');

//modulos
Route::get('/cadastros/modulos',                         [ModulosController::class, 'cadastros'])->name('cadastros.modulos');
Route::post('/cadastros/modulos',                        [ModulosController::class, 'store'])->name('modulos.store');
Route::get('/listar/modulos',                            [ModulosController::class, 'listar'])->name('listar.modulos');
Route::get('/cadastros/modulos/{modulo_id}/editar',      [ModulosController::class, 'editar'])->name('editar.modulos');
Route::put('/cadastros/modulos/{curso_id}',              [ModulosController::class, 'update'])->name('modulos.update');
//equipamentos
Route::get('/cadastros/equipamentos',                    [EquipamentosController::class, 'cadastros'])->name('cadastros.equipamentos');
Route::post('/cadastros/equipamentos',                   [EquipamentosController::class, 'store'])->name('equipamentos.store');
Route::get('/listar/equipamentos',                       [EquipamentosController::class, 'listar'])->name('listar.equipamentos');
Route::get('/cadastros/equipamentos/{modulo_id}/editar', [EquipamentosController::class, 'editar'])->name('editar.equipamentos');
Route::put('/cadastros/equipamentos/{curso_id}',         [EquipamentosController::class, 'update'])->name('equipamentos.update');

//vinculos
//alunos x cursos
Route::get('/vinculos/alunos-cursos',                    [AlunoCursoController::class, 'alunosCursos'])->name('vinculos.alunos-cursos');
Route::get('/vinculos/alunos-cursos/{aluno_id}',         [AlunoCursoController::class, 'alunosCursosVinculados'])->name('vinculos.alunos-cursos-vinculados');
Route::post('/vinculos/alunos-cursos',                   [AlunoCursoController::class, 'store'])->name('vinculos.alunos-cursos-store');
//cursos X módulos
Route::get('/vinculos/cursos-modulos',                   [CursoModuloController::class, 'cursosModulos'])->name('vinculos.cursos-modulos');
Route::get('/vinculos/cursos-modulos/{curso_id}',        [CursoModuloController::class, 'cursosModulosVinculados'])->name('vinculos.cursos-modulos-vinculados');
Route::post('/vinculos/cursos-modulos',                  [CursoModuloController::class, 'store'])->name('vinculos.cursos-modulos-store');
//módulos X equipamentos 
Route::get('/vinculos/modulos-equipamentos',             [ModuloEquipamentoController::class, 'modulosEquipamentos'])->name('vinculos.modulos-equipamentos');
Route::get('/vinculos/modulos-equipamentos/{modulo_id}', [ModuloEquipamentoController::class, 'ModulosEquipamentosVinculados'])->name('vinculos.cursos-modulos-vinculados');
Route::post('/vinculos/modulos-equipamentos',            [ModuloEquipamentoController::class, 'store'])->name('vinculos.modulos-equipamentos-store');

//configuracoes
//acessos
Route::get('/configuracao/acesso',                       [UltimoAcessoController::class,'listar'])->name('listar.acessos');
//parametros
Route::get('/configuracao/parametro',                    [ParametroController::class,'listar'])->name('listar.parametros');
Route::get('/configuracao/parametro/{param_id}/editar',  [ParametroController::class,'editar'])->name('editar.parametros');
Route::get('/configuracao/parametro/{param_id}',         [ParametroController::class, 'ParametroValor'])->name('configuracao.parametro-valor');
Route::put('/configuracao/parametro/{param_id}',         [ParametroController::class, 'update'])->name('parametro.update');

//gerar
//contratos
Route::get('/gerar/contrato',                            [ContratoController::class,'gerar'])->name('gerar.contrato');
Route::get('/gerar/contrato/{aluno_id}',                 [ContratoController::class,'alunosCursosContratos'])->name('gerar.contrato-aluno');
Route::post('/gerar/contrato',                           [ContratoController::class, 'store'])->name('gerar.contrato-aluno-curso');
Route::get('/listar/contratos',                          [ContratoController::class, 'listar'])->name('listar.contratos');
Route::get('/gerar/contrato/{contrato_id}/editar',       [ContratoController::class, 'editar'])->name('editar.contrato');
Route::put('/gerar/contrato/{contrato_id}',              [ContratoController::class, 'update'])->name('contrato.update');

//certificado
Route::get('/gerar/certificado/{controle_id}',           [AlunoCursoController::class, 'gerarCertificado'])->name('gerar.certificado');
Route::post('/gerar/certificado',                        [AlunoCursoController::class, 'emitirCertificado'])->name('emitir.certificado');

//impressão
Route::get('/gerar/certificado/{controle_id}/{aluno_id}/{curso_id}', [AlunoCursoController::class, 'imprimirCertificado'])->name('imprimir.certificado');
Route::get('/gerar/certificado/{contrato_id}/{controle_id}/{aluno_id}/{curso_id}'        , [AlunoCursoController::class, 'imprimirContrato'])->name('imprimir.contrato');

//financeiro
Route::get('/financeiro/caixa',                        [FinanceiroController::class, 'caixa'])->name('financeiro.caixa');


