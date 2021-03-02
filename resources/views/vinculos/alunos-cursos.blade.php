@extends('layouts.main')

@section('content')
    <form id="formulario" method="POST" action="{{route('vinculos.alunos-cursos-store')}}">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Vincular aluno ao(s) curso(s)</legend>  
            <div class="form-row">
                <div class="form-group col-md-6"> 
                    <label for="aluno_id">Aluno</label>
                    <select name="aluno_id" id="aluno_id" class="form-control">
                        <option>** Selecione o aluno **</option>
                        
                        @if(isset($alunos))
                            @foreach ($alunos as $aluno)
                                <option value="{{$aluno->aluno_id}}">{{$aluno->aluno_nome}}</option>
                            @endforeach
                        @endif

                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="esquerda">Curso *</label>
                    <select name="esquerda" id="esquerda" class="custom-select" multiple="multiple" size="7">

                        @if(isset($cursos))
                            @foreach ($cursos as $curso)
                                <option value="{{$curso->curso_id}}">{{$curso->curso_nome_curso}}</option>
                            @endforeach
                        @endif                      

                    </select>
                </div>
                <div class="form-group col-md-1 mx-auto d-flex align-items-center">
                    <input type="button" class="btn btn-primary" id="addAluno" value=">" onclick="moversemordem(this.form.esquerda, this.form.direita);">
                    <input type="button" class="btn btn-danger" id="removeAluno" value="<" onclick="moversemordem(this.form.direita, this.form.esquerda);">
                </div>
                <div class="form-group col-md-5">
                    <label for="direita">Cursos selecionados *</label>
                    <select name="curso_id" class="custom-select" id="direita" size="7" required="required">

                    </select>
                </div>
            </div> 
            <div class="form-row" id="dadosCurso">
                <div class="form-group col-md-4">
                    <label for="data_matricula">Matricula *</label>
                    <input type="date" class="form-control" name="data_matricula" id="data_matricula" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="data_inicio_curso">Início curso *</label>
                    <input type="date" class="form-control" name="data_inicio_curso" id="data_inicio_curso" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="aluno_hor">Horário *</label>
                    <input type="text" class="form-control" name="aluno_hor" id="aluno_hor" required>
                </div>
            </div>                           
            <div class="form-row">
                <div class="form-group col-md-1">
                    <input type="submit" id="enviar" class="btn btn-primary" value="Salvar">
                </div>
            </div>
            <fieldset class="border p-2">
                <legend class="w-auto">Cursos já vinculados</legend>
                <table class="table table-striped" id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Início</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">Horário</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaCursosVinculados">
                        <tr scope="row">
                            
                        </tr>
                    <tbody>
                </table>
            </fieldset>
        </div>                
    </fieldset>
    </form>

    @section('scripts')
        <script>
            $('#aluno_id').on("change", function(){
                aluno_id = $("#aluno_id").val();
                $.get("/vinculos/alunos-cursos/"+aluno_id, function(data){
                    $("#tabelaCursosVinculados").empty();
                    $.each(data, function(key, value){
                        $("#tabelaCursosVinculados").append('<tr><td><input type="checkbox" value="'+value.controle_id+'"></td><td>'+value.controle_id+'</td><td>'+value.curso_nome_curso+'</td><td>'+formataData(value.curso_inicio)+'</td><td>'+formataData(value.curso_matricula)+'</td><td>'+value.aluno_hor+'</td></tr>');
                    });
                });
            });
        </script>
    @endsection
@stop