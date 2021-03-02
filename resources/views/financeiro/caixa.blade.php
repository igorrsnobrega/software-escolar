@extends('layouts.main')

@extends('layouts.actions')

@section('content')

    <form id="formulario" method="POST" action="{{route('alunos.store')}}">

    @csrf

    <fieldset class="border p-2">
        <legend class="w-auto">Caixa</legend>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="operador">Operador </label>
                <input type="text" class="form-control" name="operador" id="operador" value="{{ Auth::user()->name }}" disabled require>
            </div>
            <div class="form-group col-md-1">
                <label for="aluno_id">Aluno ID </label>
                <input type="text" class="form-control" name="aluno_id" id="aluno_id" value="" require>
            </div>
            <div class="form-group col-md-4">
                <label for="aluno_nome">Aluno </label>
                <input type="text" class="form-control" name="aluno_nome" id="aluno_nome" value="" require>
                <div id="aluno_lista"></div>
            </div>
            <div class="form-group col-md-5">
                <label for="operador">Forma de pagamento </label>
                <select class="form-control" name="forma_pagamento" id="forma_pagamento">
                    <option value="1">Boleto</option>  
                    <option value="2">Cartão de crédito</option>
                    <option value="3">Cartão de débito</option> 
                    <option value="4">Dinheiro</option>
                </select>
            </div>
        </div>
        <div class="text-center">
            <p class="fw-bold">*Campos obrigatórios.</p>
        </div>
    </fieldset>
    <fieldset class="border p-2">
        <legend class="w-auto">Observações</legend>
        <div class="form">
            <div class="form-group col-md-12">
                <textarea class="form-control" name="caixa_observacao" id="caixa_observacao" cols="30" rows="3">{{old('caixa_observacao')}}</textarea>
            </div>
            <div class="col-md-12">
                <input type="submit" id="enviar" class="btn btn-primary form-control" value="Salvar">
            </div>
        </div>
    </fieldset>
</form>

@section('scripts')
    <script>
        $('#aluno_nome').on("change", function(){
            aluno_nome = $("#aluno_nome").val();
                $.get("/gerar/contrato/"+aluno_nome, function(data){
                    $("#aluno_lista").empty();
                    $.each(data, function(key, value){
                        $("#aluno_lista").append('<option value="'+value.curso_id+'">'+value.curso_nome_curso+'</option>');
                    });
                });
            });
    </script>
@endsection

@stop