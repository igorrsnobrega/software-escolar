@extends('layouts.main')

@section('content')

<form id="formulario" method="post" action="{{ route('emitir.certificado') }}">
    @csrf
    <fieldset class="border p-2">
        <legend class="w-auto">Dados aluno</legend>
        <div class="form-row">

            <div class="form-group col-md-12">
                <label for="aluno_id">Aluno</label>
                @if (isset($gerarCertificado))
                    <input type="hidden" class="form-control" id="alunos_cursos_controle_id" name="alunos_cursos_controle_id" value="{{$gerarCertificado->controle_id}}">
                    <input type="hidden" class="form-control" id="aluno_id" name="aluno_id" value="{{$gerarCertificado->aluno_id}}">
                    <input type="text" class="form-control" id="aluno_nome" name="aluno_nome" value="{{$gerarCertificado->aluno_nome}}" readonly>
                @endif
            </div>
            <div class="form-group col-md-12">
                <label for="curso_id">Curso</label>
                @if (isset($gerarCertificado))
                    <input type="hidden" class="form-control" id="curso_id" name="curso_id" value="{{$gerarCertificado->curso_id}}">
                    <input type="text" class="form-control" id="curso_nome" value="{{$gerarCertificado->curso_nome_curso}}" readonly>               
                @endif
            </div>

        </div>
    </fieldset>
    <fieldset class="border p-2">
        <legend class="w-auto">Notas</legend>
        <div class="form-row" id="">

            @if (isset($modulos))
                @foreach ($modulos as $modulo)
                    <div class="form-group col-md-10">
                        <input type="hidden" name="modulo_id[]" class="form-control" value="{{$modulo->modulo_id}}">
                        <input type="text" class="form-control" value="{{$modulo->modulo_descricao}}" readonly>               
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" name="modulo_notas[]" class="form-control">   
                    </div>
                @endforeach  
            @endif
        
            <div class="inform-finais">
                <span>*Campos obrigatórios.</span>
            </div>
        </div>        
    </fieldset>

    <fieldset class="border p-2">
        <legend class="w-auto">Detalhes</legend>
        <div class="form-row" id="">
            <div class='form-group col-md-12'>
                <label for='aluno_empresa'>Aluno Empresa *</label>
                <select id="aluno_empresa" class="form-control" title="Define se o aluno será certificado com notas" onchange="ocultaCampo('aluno_empresa', '.modulo_notas')">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
        </div>
        <div class="form-row" id="">
            <div class='form-group col-md-4'>
                <label for='nota_data_certificao'>Data certificação *</label>
                <input type='date' name='nota_data_certificacao' class='form-control'>
            </div>
            <div class='form-group col-md-4'>
                <label for='nota_data_termino'>Data término curso *</label>
                <input type='date' name='nota_data_termino' class='form-control'>
            </div>
            <div class='form-group col-md-4'>
                <label for='nota_frequencia'>Frequência **</label>
                <input type='number' min="75" max="100" name='nota_frequencia' class='form-control'>
            </div>
        </div>
        <div class="form-row" id="">
            <div class='form-group col-md-12'>
                <label for='nota_observacao'>Observações *</label>
                <textarea name="nota_observacao" cols="30" rows="5" class="form-control"></textarea>
            </div>
        </div>
        <div class="inform-finais">
            <span>*Campos obrigatórios.</span>
            <span>**Frequência miníma de 70% exigido.</span>
        </div>
    </fieldset>
    <div class="form-row">
        <div class="form-group col-md-12">
            <input type="submit" class="btn btn-primary form-control" value="Salvar">
        </div>
    </div>    
    </form>

    @section('scripts')
        <script>
            
        </script>
    @endsection
@stop