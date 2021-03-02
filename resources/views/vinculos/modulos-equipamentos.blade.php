@extends('layouts.main')

@section('content')
    <form id="formulario" method="POST" action="{{route('vinculos.modulos-equipamentos-store')}}">
        @csrf
        <fieldset class="border p-2">
            <legend class="w-auto">Vincular módulo ao(s) equipamento(s)</legend>  
            <div class="form-row">
                <div class="form-group col-md-6"> 
                    <label for="modulo_id">Módulo</label>
                    <select name="modulo_id" id="modulo_id" class="form-control">
                        <option>** Selecione o módulo **</option>
                        
                        @if(isset($modulos))
                            @foreach ($modulos as $modulo)
                                <option value="{{$modulo->modulo_id}}">{{$modulo->modulo_descricao}}</option>
                            @endforeach
                        @endif

                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="esquerda">Equipamentos *</label>
                    <select name="esquerda" id="esquerda" class="custom-select" multiple="multiple" size="7">

                        @if(isset($equipamentos))
                            @foreach ($equipamentos as $equipamento)
                                <option value="{{$equipamento->equip_id}}">{{$equipamento->equip_desc}}</option>
                            @endforeach
                        @endif                      

                    </select>
                </div>
                <div class="form-group col-md-1 mx-auto d-flex align-items-center">
                    <input type="button" class="btn btn-primary" id="addAluno" value=">" onclick="moversemordem(this.form.esquerda, this.form.direita);">
                    <input type="button" class="btn btn-danger" id="removeAluno" value="<" onclick="moversemordem(this.form.direita, this.form.esquerda);">
                </div>
                <div class="form-group col-md-5">
                    <label for="direita">Equipamentos selecionados *</label>
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
                <legend class="w-auto">Equipamentos já vinculados</legend>
                <table class="table table-striped" id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">Equipamento</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaEquipamentosVinculados">
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
            $('#modulo_id').on("change", function(){
                modulo_id = $("#modulo_id").val();
                $.get("/vinculos/modulos-equipamentos/"+modulo_id, function(data){
                    $("#tabelaEquipamentosVinculados").empty();
                    $.each(data, function(key, value){
                        $("#tabelaEquipamentosVinculados").append('<tr><td><input type="checkbox" value="'+value.controle_id+'"></td><td>'+value.controle_id+'</td><td>'+value.equip_desc+'</td></tr>');
                    });
                });
            });
        </script>
    @endsection
@stop