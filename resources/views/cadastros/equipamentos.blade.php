@extends('layouts.main')

@section('content')

@if (!isset($equipamento))
        <form id="formulario" method="POST" action="{{route('equipamentos.store')}}">
    @else
        <form id="formulario" method="POST" action="{{route('equipamentos.update', $equipamento->equip_id)}}">
        {!! method_field('PUT') !!}
    @endif

    @csrf
    <fieldset class="border p-2">
        @if (!isset($equipamento))
            <legend class="w-auto">Cadastro de equipamento</legend>
        @else
            <legend class="w-auto">Editar equipamento</legend>
        @endif
        <div class="form-row" id="div_formulario">

            @if (!isset($equipamento))
                <div class="form-group col-md-10">
                    <label for="">Descrição *</label>
                    <input type="text" name="array_item[]" class="form-control">
                </div> 
                <div class="form-group col-md-2">
                    <label for="">Adicionar equipamentos</label>
                    <button type="button" id="add_campo" class="btn btn-primary form-control">+</button>
                </div>
            @else
                <div class="form-group col-md-12">
                    <label for="">Descrição *</label>
                    <input type="text" name="equip_desc" class="form-control" value="{{$equipamento->equip_desc}}">
                </div> 
            @endif

        </div>
        <div class="text-center">
            <span>*Campos obrigatórios.</span>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <button type="submit" id="enviar" class="btn btn-primary form-control espacamento-superior">Salvar</button>
            </div>
        </div>
    </fieldset>
</form> 
@section('scripts')
    <script>
        var cont = 1;
            $("#add_campo").click(function(){
                cont++;
                $("#div_formulario").append('<div id="campo'+ cont +'" class="form-row col-md-12"><div class="form-group col-md-10"><label for="array_item">Descrição *</label><input type="text" name="array_item[]" class="form-control"></div><div class="form-group col-md-2"><label for="">Remover</label><button type="button" id="'+ cont +'" class="btn-apagar btn btn-danger form-control">-</button></div></div>')
            });
            $("form").on("click", ".btn-apagar", function(){
                var button_id = $(this).attr("id");
                $('#campo'+ button_id +'').remove();
            });
    </script>
@endsection

@stop