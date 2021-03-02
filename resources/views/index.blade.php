@extends('layouts.main')

@section('content')

<fieldset class="border p-2">
  <legend class="w-auto">Dashboard</legend>

  <div class="card-columns">

    <div class="card bg-light mb-3" style="max-width: 18rem;">
      <div class="card-header">Novos Alunos</div>
      <div class="card-body">

        @if(isset($novosAlunos))
          @foreach ( $novosAlunos as $aluno )
          <h5 class="card-title"> {{ $aluno->novos_aluno_mes }} </h5>
          @endforeach
        @endif

        @if(isset($periodo))
          @foreach ( $periodo as $periodo )
            <p class="card-text">*Período {{date('d/m/Y', strtotime($periodo->primeiro_dia))}} até {{date('d/m/Y', strtotime($periodo->ultimo_dia))}}</p>
          @endforeach
        @endif

      </div>
    </div>

    <div class="card bg-light mb-3" style="max-width: 18rem;">
      <div class="card-header">Novos Alunos mês anterior</div>
      <div class="card-body">

        @if(isset($novosAlunosMesPassado))
          @foreach ( $novosAlunosMesPassado as $novosAlunosMesPassado )
          <h5 class="card-title"> {{ $novosAlunosMesPassado->novos_aluno_mes_passado }} </h5>
          @endforeach
        @endif

        @if(isset($periodo))
            <p class="card-text">*Período {{ date('d/m/Y', strtotime($periodo->primeiro_dia_mes_passado)) }} até {{ date('d/m/Y', strtotime($periodo->ultimo_dia_mes_passado)) }}</p>
        @endif

      </div>
    </div>

    <div class="card bg-light mb-3" style="max-width: 18rem;">
      <div class="card-header">Cursos mais procurados</div>
      <div class="card-body">

        @if(isset($cursosMaisProcurados))
          @foreach ( $cursosMaisProcurados as $cursoMaisProcurado )
          <span class="card-text"> {{ $cursoMaisProcurado->curso_nome_curso }} </span><br>
          @endforeach
        @endif

        @if(isset($periodo))
          <p class="card-text">*Período {{date('d/m/Y', strtotime($periodo->primeiro_dia))}} até {{date('d/m/Y', strtotime($periodo->ultimo_dia))}}</p>
        @endif

      </div>
    </div>

  </div>
</fieldset>
@stop
