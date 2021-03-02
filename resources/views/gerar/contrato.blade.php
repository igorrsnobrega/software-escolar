@extends('layouts.main')

@section('content')

    @if (!isset($contratos))
        <form id="formulario" method="post" action="{{route('gerar.contrato-aluno-curso')}}">
    @else
        <form id="formulario" method="POST" action="{{route('contrato.update', $contratos->cont_id)}}">
        {!! method_field('PUT') !!}
    @endif

    @csrf

        <fieldset class="border p-2">

            @if (!isset($contratos))
                <legend class="w-auto">Gerar contrato</legend>
            @else
                <legend class="w-auto">Editar contrato</legend>
            @endif            

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="aluno_id">Aluno *</label>

                        @if (!isset($contratos))              
                            <select name="aluno_id" id="aluno_id" class="form-control">
                                <option value="#">** Selecione um aluno **</option>

                                @foreach ($alunos as $aluno)
                                    <option value="{{$aluno->aluno_id}}">{{$aluno->aluno_nome}}</option>
                                @endforeach
                            </select>
                        @else
                            <select name="aluno_id" id="aluno_id" class="form-control">
                                <option value="{{$contratos->cont_aluno}}">{{$contratos->aluno_nome}}</option>  
                            </select>                          
                        @endif
                    
                </div>
            </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="curso_id">Curso *</label>               
                
                @if (!isset($contratos))
                    <select name="curso_id" id="curso_id" class="form-control" title="Listado somente cursos que ainda não possuem contrato">
                        
                    </select>
               
                @else
                    <select name="curso_id" id="curso_id" class="form-control" title="Listado somente cursos que ainda não possuem contrato">
                        <option value="{{$contratos->cont_curso}}">{{$contratos->curso_nome_curso}}</option>
                    </select>
                @endif
                
            </div>
        </div>
            <div class="form-row">
            <div class="form-group col-md-3">
                <label for="cont_valor_integral">Valor integral *</label>  

                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_integral" value="{{old('cont_valor_integral')}}" name="cont_valor_integral" required>
                @else
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_integral" value="{{str_replace('.',',', $contratos->cont_valor_integral)}}" name="cont_valor_integral" required>
                @endif   

            </div>
            <div class="form-group col-md-3">
                <label for="cont_valor_desconto">Desconto:</label>

                @if (!isset($contratos))
                    <input type="text" placeholder="%" class="form-control" id="cont_valor_desconto" value="{{old('cont_valor_desconto')}}" onchange="calculaDesconto()" name="cont_valor_desconto" required>
                @else
                    <input type="text" placeholder="%" class="form-control" id="cont_valor_desconto" value="{{str_replace('.',',', $contratos->cont_valor_desconto)}}" onchange="calculaDesconto()" name="cont_valor_desconto" required>
                @endif                  
                
            </div>
            <div class="form-group col-md-3">
                <label for="cont_vDesconto">Valor desconto:</label>  

                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" id="cont_vDesconto" value="{{old('cont_vDesconto')}}" name="cont_vDesconto" required readonly>
                @else
                    <input type="text" placeholder="R$" class="form-control" id="cont_vDesconto" value="{{str_replace('.',',', $contratos->cont_vDesconto)}}" name="cont_vDesconto" required readonly>
                @endif  
                
            </div>
            <div class="form-group col-md-3">
                <label for="cont_valor_final">Valor final:</label>  

                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_final" value="{{old('cont_valor_final')}}" name="cont_valor_final" required readonly>
                @else
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_final" value="{{str_replace('.',',', $contratos->cont_valor_final)}}" name="cont_valor_final" required readonly>
                @endif
                
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cont_valor_entrada">Entrada:</label>

                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_entrada" value="{{old('cont_valor_entrada')}}" name="cont_valor_entrada" required>                    
                @else
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_entrada" value="{{str_replace('.',',', $contratos->cont_valor_entrada)}}" name="cont_valor_entrada" required>                    
                @endif

            </div>
            <div class="form-group col-md-6">
                <label for="cont_data_entrada">Data entrada:</label>  

                @if (!isset($contratos))
                    <input type="date" class="form-control" id="cont_data_entrada" name="cont_data_entrada" value="{{old('cont_data_entrada')}}" title="Data de matrícula do aluno">
                @else
                    <input type="date" class="form-control" id="cont_data_entrada" name="cont_data_entrada" value="{{ date('d/m/Y', strtotime($contratos->cont_data_entrada)) }}" title="Data de matrícula do aluno">
                @endif
                
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cont_matricula">Matrícula:</label>  

                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" value="{{old('cont_matricula')}}" id="cont_matricula" name="cont_matricula" required>
                @else
                    <input type="text" placeholder="R$" class="form-control" value="{{str_replace('.',',', $contratos->cont_matricula)}}" id="cont_matricula" name="cont_matricula" required>
                @endif

            </div>
            <div class="form-group col-md-6">
                <label for="cont_material">Material didático:</label>  

                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" value="{{old('cont_material')}}" id="cont_material" name="cont_material" required>
                @else
                    <input type="text" placeholder="R$" class="form-control" value="{{str_replace('.',',', $contratos->cont_material)}}" id="cont_material" name="cont_material" required>
                @endif
                
            </div>
            <div class="form-group col-md-3">
                <label for="cont_qtdParcela">Quantidade de parcelas:</label>  

                @if (!isset($contratos))
                    <input type="number" min="1" placeholder="" class="form-control" value="{{old('cont_qtdParcela')}}" id="cont_qtdParcela" name="cont_qtdParcela" onchange="calculaParcelas()" required>
                @else
                    <input type="number" min="1" placeholder="" class="form-control" id="cont_qtdParcela" value="{{$contratos->cont_n_parcela}}" name="cont_qtdParcela" onchange="calculaParcelas()" required>
                @endif
                
            </div>
            <div class="form-group col-md-3">
                <label for="cont_valor_parcelas">Valor da parcela:</label> 
                
                @if (!isset($contratos))
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_parcelas" value="{{old('cont_valor_parcelas')}}" name="cont_valor_parcelas" required readonly>                    
                @else
                    <input type="text" placeholder="R$" class="form-control" id="cont_valor_parcelas" value="{{str_replace('.',',', $contratos->cont_valor_parcelas)}}" name="cont_valor_parcelas" required readonly>
                @endif

            </div>
            <div class="form-group col-md-3">
            <label for="cont_data_vencimento">Dia de vencimento:</label>  

                @if (!isset($contratos))
                    <input type="text" class="form-control" value="{{old('cont_data_vencimento')}}" name="cont_data_vencimento" title="**Somente o dia" required>    
                @else
                    <input type="text" class="form-control" value="{{$contratos->cont_data_vencimento}}" name="cont_data_vencimento" title="**Somente o dia" required>
                @endif

            </div>
            <div class="form-group col-md-3">
                <label for="cont_dataPrimeiroPagamento">Data primeiro pagamento: *</label>  

                @if (!isset($contratos))
                    <input type="date" class="form-control" value="{{old('cont_dataPrimeiroPagamento')}}" name="cont_dataPrimeiroPagamento" title="Data para o pagamento da primeira parcela">                    
                @else
                    <input type="date" class="form-control" value="{{$contratos->cont_dataPrimeiroPagamento}}" name="cont_dataPrimeiroPagamento" title="Data para o pagamento da primeira parcela">
                @endif

            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-12">
                <label for="cont_fomraPagamento">Forma de pagamento: *</label>  
                <select name="cont_fomraPagamento" id="cont_fomraPagamento" class="form-control">                    
                    @if (!isset($contratos))
                        <option value="1">Boleto</option>  
                        <option value="2">Cartão de crédito</option>
                        <option value="3">Cartão de débito</option> 
                        <option value="4">Dinheiro</option>                          
                    @else
                        <option value="1" @if($contratos->cont_fomraPagamento == 1) selected @endif >Boleto</option>  
                        <option value="2" @if($contratos->cont_fomraPagamento == 2) selected @endif >Cartão de crédito</option>
                        <option value="3" @if($contratos->cont_fomraPagamento == 3) selected @endif >Cartão de débito</option> 
                        <option value="4" @if($contratos->cont_fomraPagamento == 4) selected @endif >Dinheiro</option>                
                    @endif
                </select>
            </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-12">
                <label for="cont_observacoes">Observações: </label>  

                @if (!isset($contratos))
                    <textarea class="form-control" name="cont_observacoes" id="cont_observacoes" cols="30" rows="3">{{old('cont_observacoes')}}</textarea>
                @else
                    <textarea class="form-control" name="cont_observacoes" id="cont_observacoes" cols="30" rows="3">{{$contratos->cont_observacoes}}</textarea>
                @endif
                
            </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    @if (!isset($contratos))
                        <input type="submit" class="btn btn-primary form-control espacamento-superior" value="GERAR CONTRATO">  
                    @else
                        <input type="submit" class="btn btn-primary form-control espacamento-superior" value="ATUALIZAR CONTRATO">  
                    @endif
                        
            </div>
        </fieldset>
    </form>

    @section('scripts')
        <script>
            $('#aluno_id').on("change", function(){
                aluno_id = $("#aluno_id").val();
                $.get("/gerar/contrato/"+aluno_id, function(data){
                    $("#curso_id").empty();
                    $.each(data, function(key, value){
                        $("#curso_id").append('<option value="'+value.curso_id+'">'+value.curso_nome_curso+'</option>');
                    });
                });
            });
        </script>
    @endsection
@stop