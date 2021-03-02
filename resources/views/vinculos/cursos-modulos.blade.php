@extends('layouts.main')

@section('content')
    <form id="formulario" method="POST" action="{{route('vinculos.cursos-modulos-store')}}">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Vincular curso ao(s) módulos(s)</legend>  
            <div class="form-row">
                <div class="form-group col-md-6"> 
                    <label for="curso_id">Aluno</label>
                    <select name="curso_id" id="curso_id" class="form-control">
                        <option>** Selecione o curso **</option>
                        
                        @if(isset($cursos))
                            @foreach ($cursos as $curso)
                                <option value="{{$curso->curso_id}}">{{$curso->curso_nome_curso}}</option>
                            @endforeach
                        @endif

                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="esquerda">Módulos *</label>
                    <select name="esquerda" id="esquerda" class="custom-select" multiple="multiple" size="7">

                        @if(isset($modulos))
                            @foreach ($modulos as $modulo)
                                <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_descricao}}</option>
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
                    <select name="array_item[]" class="custom-select" id="direita" size="7" multiple="multiple" required="required">
                                            
                    </select>
                </div>
            </div>                           
            <div class="form-row">
                <div class="form-group col-md-1">
                    <input type="submit" id="enviar" class="btn btn-primary" value="Salvar">
                </div>
            </div>
            <fieldset class="border p-2">
                <legend class="w-auto">Módulos já vinculados</legend>
                <table class="table table-striped" id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Módulo</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaModulosVinculados">
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
            $('#curso_id').on("change", function(){
                curso_id = $("#curso_id").val();
                $.get("/vinculos/cursos-modulos/"+curso_id, function(data){
                    $("#tabelaModulosVinculados").empty();
                    $.each(data, function(key, value){
                        $("#tabelaModulosVinculados").append('<tr><td><input type="checkbox" value="'+value.controle_id+'"></td><td>'+value.controle_id+'</td><td>'+value.modulo_descricao+'</td></tr>');
                    });
                });
            });
        </script>
    @endsection
@stop