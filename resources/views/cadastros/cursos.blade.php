@extends('layouts.main')

@section('content')

    @if (!isset($curso))
        <form id="formulario" enctype="multipart/form-data" method="POST" action="{{route('cursos.store')}}">
    @else
        <form id="formulario" enctype="multipart/form-data" method="POST" action="{{route('cursos.update', $curso->curso_id)}}">
        {!! method_field('PUT') !!}
    @endif

    @csrf
    <fieldset class="border p-2">
        @if (!isset($curso))
            <legend  class="w-auto">Cadastro de curso</legend>
        @else
            <legend  class="w-auto">Editar curso</legend>
        @endif        
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_nome_curso">Título *</label>
                @if (!isset($curso))
                    <input type="text" name="curso_nome_curso" class="form-control" id="curso_nome_curso" value="{{old('curso_nome_curso')}}" required>
                @else
                    <input type="text" name="curso_nome_curso" class="form-control" id="curso_nome_curso" value="{{$curso->curso_nome_curso}}" required>
                @endif                
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_frase">Frase *</label>
                @if (!isset($curso))
                    <input type="text" name="curso_frase" class="form-control" id="curso_frase" value="{{old('curso_frase')}}" required>
                @else
                    <input type="text" name="curso_frase" class="form-control" id="curso_frase" value="{{$curso->curso_frase}}" required>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_cargaHoraria">Carga horária *</label>
                @if (!isset($curso))
                    <input type="text" name="curso_cargaHoraria" class="form-control" id="curso_cargaHoraria" value="{{old('curso_cargaHoraria')}}" required>
                @else
                    <input type="text" name="curso_cargaHoraria" class="form-control" id="curso_cargaHoraria" value="{{$curso->curso_cargaHoraria}}" required>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_pq">Por que fazer? *</label>
                @if (!isset($curso))
                    <textarea name="curso_pq" class="form-control" id="curso_pq" cols="30" rows="5" required>{{old('curso_pq')}}</textarea>
                @else
                    <textarea name="curso_pq" class="form-control" id="curso_pq" cols="30" rows="5" required>{{$curso->curso_pq}}</textarea>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_quem">Quem deve fazer? *</label>
                @if (!isset($curso))
                    <textarea name="curso_quem" class="form-control" id="curso_quem" cols="30" rows="5" required>{{old('curso_quem')}}</textarea>
                @else
                    <textarea name="curso_quem" class="form-control" id="curso_quem" cols="30" rows="5" required>{{$curso->curso_quem}}</textarea>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_recompensa">Recompensas? *</label>
                @if (!isset($curso))
                    <textarea name="curso_recompensa" class="form-control" id="curso_recompensa" cols="30" rows="5" required>{{old('curso_recompensa')}}</textarea>
                @else
                    <textarea name="curso_recompensa" class="form-control" id="curso_recompensa" cols="30" rows="5" required>{{$curso->curso_recompensa}}</textarea>
                @endif
            </div>
        </div>
        <span>Imagens</span>
        <div class="form">
            <div class="form-row">
                <div class="form-group col-md-12"> 
                    @if (!isset($curso))
                        <input type="file" class="form-control-file" name="imagemCurso1" id="imagemCurso1">
                    @else
                        <img src="{{asset('/img/cursos/' . $curso->imagemCurso1)}}" width="150" title="Imagem atual">
                        <input type="file" class="form-control-file mt-2" name="imagemCurso1" id="imagemCurso1">
                    @endif 
                </div>
            </div>
        </div>
        <div class="inform-finais">
            <span>*Campos obrigatórios.</span>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <button type="submit" id="enviar" class="btn btn-primary form-control espacamento-superior">Salvar</button>
            </div>
        </div>
    </fieldset>
</form>   

@stop