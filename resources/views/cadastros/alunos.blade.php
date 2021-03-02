@extends('layouts.main')

@extends('layouts.actions')

@section('content')

    @if (!isset($aluno))
        <form id="formulario" method="POST" action="{{route('alunos.store')}}">
    @else
        <form id="formulario" method="POST" action="{{route('alunos.update', $aluno->aluno_id)}}">
        {!! method_field('PUT') !!}
    @endif

    @csrf

    <fieldset class="border p-2">
        @if (!isset($aluno))
            <legend class="w-auto">Cadastro de aluno</legend>
        @else
            <legend class="w-auto">Editar aluno</legend>
        @endif

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="aluno_nome">Nome *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" name="aluno_nome" id="aluno_nome" value="{{old('aluno_nome')}}" require>                     
                @else
                    <input type="text" class="form-control" name="aluno_nome" id="aluno_nome" value="{{$aluno->aluno_nome}}" require>                     
                @endif
                
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="aluno_tel">Telefone *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_tel" name="aluno_tel" value="{{old('aluno_tel')}}">
                @else
                    <input type="text" class="form-control" id="aluno_tel" name="aluno_tel" value="{{$aluno->aluno_tel}}">
                @endif                
            </div>
            <div class="form-group col-md-2">
                <label for="aluno_cel">Celular *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_cel" name="aluno_cel" value="{{old('aluno_cel')}}">
                @else
                    <input type="text" class="form-control" id="aluno_cel" name="aluno_cel" value="{{$aluno->aluno_cel}}">
                @endif 
            </div>
            <div class="form-group col-md-4">
                <label for="aluno_email">E-mail</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_email" name="aluno_email" value="{{old('aluno_email')}}">
                @else
                    <input type="text" class="form-control" id="aluno_email" name="aluno_email" value="{{$aluno->aluno_email}}">
                @endif
            </div>
            <div class="form-group col-md-2">
                <label for="aluno_rg">RG</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_rg" name="aluno_rg" value="{{old('aluno_rg')}}">
                @else
                    <input type="text" class="form-control" id="aluno_rg" name="aluno_rg" value="{{$aluno->aluno_rg}}">
                @endif
            </div>
            <div class="form-group col-md-2">
                <label for="aluno_cpf">CPF</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_cpf" name="aluno_cpf" value="{{old('aluno_cpf')}}">
                @else
                    <input type="text" class="form-control" id="aluno_cpf" name="aluno_cpf" value="{{$aluno->aluno_cpf}}">
                @endif
            </div>
            <div class="form-group col-md-3">
                <label for="aluno_nasc">Nascimento *</label>
                @if (!isset($aluno))
                    <input type="date" class="form-control" id="aluno_nasc" name="aluno_nasc" value="{{old('aluno_nasc')}}" required>
                @else
                    <input type="date" class="form-control" id="aluno_nasc" name="aluno_nasc" value="{{$aluno->aluno_nasc}}" required>
                @endif
            </div>
            <div class="form-group col-md-2">
                <label for="aluno_cep">CEP</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_cep" name="aluno_cep" value="{{old('aluno_cep')}}">
                @else
                    <input type="text" class="form-control" id="aluno_cep" name="aluno_cep" value="{{$aluno->aluno_cep}}">
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="aluno_end">Endereço *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_end" name="aluno_end" value="{{old('aluno_end')}}" required>
                @else
                    <input type="text" class="form-control" id="aluno_end" name="aluno_end" value="{{$aluno->aluno_end}}" required>
                @endif
            </div>
            <div class="form-group col-md-1">
                <label for="aluno_num_casa">Número *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_num_casa" name="aluno_num_casa" value="{{old('aluno_num_casa')}}" required>
                @else
                    <input type="text" class="form-control" id="aluno_num_casa" name="aluno_num_casa" value="{{$aluno->aluno_num_casa}}" required>
                @endif
            </div>
            <div class="form-group col-md-5">
                <label for="aluno_bairro">Bairro *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_bairro" name="aluno_bairro" value="{{old('aluno_bairro')}}" required>
                @else
                    <input type="text" class="form-control" id="aluno_bairro" name="aluno_bairro" value="{{$aluno->aluno_bairro}}" required>
                @endif
            </div>
            <div class="form-group col-md-5">
                <label for="aluno_cidade">Cidade *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_cidade" name="aluno_cidade" value="{{old('aluno_cidade')}}" required>
                @else
                    <input type="text" class="form-control" id="aluno_cidade" name="aluno_cidade" value="{{$aluno->aluno_cidade}}" required>
                @endif
            </div>
            <div class="form-group col-md-2">
                <label for="aluno_estado">Estado *</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_estado" name="aluno_estado" value="{{old('aluno_estado')}}" required>
                @else
                    <input type="text" class="form-control" id="aluno_estado" name="aluno_estado" value="{{$aluno->aluno_estado}}" required>
                @endif
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="aluno_resp">Responsável (**)</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_resp" name="aluno_resp" title="**Para alunos menores de 18 anos." value="{{old('aluno_resp')}}">
                @else
                    <input type="text" class="form-control" id="aluno_resp" name="aluno_resp" title="**Para alunos menores de 18 anos." value="{{$aluno->aluno_resp}}">
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="aluno_rg_resp">RG responsável (**)</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_rg_resp" name="aluno_rg_resp" title="**Para alunos menores de 18 anos." value="{{old('aluno_rg_resp')}}">
                @else
                    <input type="text" class="form-control" id="aluno_rg_resp" name="aluno_rg_resp" title="**Para alunos menores de 18 anos." value="{{$aluno->aluno_rg_resp}}">
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="aluno_cpf_resp">CPF responsável (**)</label>
                @if (!isset($aluno))
                    <input type="text" class="form-control" id="aluno_cpf_resp" name="aluno_cpf_resp" title="**Para alunos menores de 18 anos." value="{{old('aluno_cpf_resp')}}">
                @else
                    <input type="text" class="form-control" id="aluno_cpf_resp" name="aluno_cpf_resp" title="**Para alunos menores de 18 anos." value="{{$aluno->aluno_cpf_resp}}">
                @endif
            </div>
        </div>
        <div class="text-center">
            <p class="fw-bold">*Campos obrigatórios. **Campo responsável obrigatório para alunos menores de 18 anos.</p>
        </div>
    </fieldset>
    <fieldset class="border p-2">
        <legend class="w-auto">Observações</legend>
        <div class="form">
            <div class="form-group col-md-12">
                @if (!isset($aluno))
                    <textarea class="form-control" name="aluno_obs" id="aluno_obs" cols="30" rows="3">{{old('aluno_obs')}}</textarea>
                @else
                    <textarea class="form-control" name="aluno_obs" id="aluno_obs" cols="30" rows="3">{{$aluno->aluno_obs}}</textarea>
                @endif
            </div>
            <div class="col-md-12">
                <input type="submit" id="enviar" class="btn btn-primary form-control" value="Salvar">
            </div>
        </div>
    </fieldset>
</form>

@stop