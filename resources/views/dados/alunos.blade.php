@extends('layouts.main')

@section('content')
    <form id="formulario" method="get">
        <fieldset class="border p-2">
            <legend class="w-auto">Dados Aluno</legend>
            <div class="">

                <div class="card">
                    <h5 class="card-header">{{$aluno->aluno_nome}}</h5>
                    <div class="card-body">
                        <input type="hidden" name="aluno_id" id="aluno_id" value="{{$aluno->aluno_id}}">
                    
                        @if (!empty($aluno->aluno_rg))
                        <strong>RG: </strong> {{$aluno->aluno_rg}}
                        @endif

                        @if ($aluno->aluno_cpf)
                        <strong>CPF: </strong> {{$aluno->aluno_cpf}}   
                        @endif
                        <strong>NASCIMENTO: </strong> {{date('d/m/Y', strtotime($aluno->aluno_nasc))}}<br/>

                        <strong>TEL.: </strong> {{$aluno->aluno_tel}}
                        <strong>CEL.: </strong> {{$aluno->aluno_cel}}
                        <strong>E-MAIL: </strong> {{$aluno->aluno_email}}<br/>

                        <strong>END.: </strong> {{$aluno->aluno_end}}

                        @if ($aluno->aluno_num_casa)
                            <strong>Nº: </strong> {{$aluno->aluno_num_casa}}
                        @endif

                        @if (!empty($aluno->aluno_cep))
                        <strong>CEP: </strong> {{$aluno->aluno_cep}}
                        @endif

                        <strong>BAIRRO: </strong> {{$aluno->aluno_bairro}}
                        <strong>CIDADE: </strong> {{$aluno->aluno_cidade}}
                        <strong>ESTADO: </strong> {{$aluno->aluno_estado}}<br/>

                        @if (!empty($aluno->aluno_resp))
                            <strong>RESPONSAVEL: </strong> {{$aluno->aluno_resp}}
                            <strong>RESPONSAVEL RG: </strong> {{$aluno->aluno_rg_resp}}
                            <strong>RESPONSAVEL CPF: </strong> {{$aluno->aluno_cpf_resp}}<br/>
                        @endif

                        <strong>OBSERVAÇÕES: </strong> {{$aluno->aluno_obs}}<br/>
                    
                    </div>
                </div>
                

            </div>
        </fieldset>
        <fieldset class="border p-2">
            <legend class="w-auto">Histórico</legend>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>                    
                    <th>ID</th>
                    <th>Curso</th>
                    <th>Início</th>
                    <th>Conclusão</th>
                    <th>Certificado</th>
                    <th style="width: 260px;">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaCursosVinculados">
                <tr scope="row">
                    
                </tr>
            <tbody>
        </table>
        </fieldset>
    </form>
    @section('scripts')
        <script>
            $(window).on("load", function(){
                aluno_id = $("#aluno_id").val();
                $.get("/vinculos/alunos-cursos/"+aluno_id, function(data){
                    $("#tabelaCursosVinculados").empty();
                    $.each(data, function(key, value){
                        var data_inicio_curso    = value.curso_inicio            != null ? formataData(value.curso_inicio) : 'Cursando';
                        var data_conclusao_curso = value.curso_fim               != null ? formataData(value.curso_fim) : 'Cursando';
                        var data_certificacao    = value.curso_data_certificacao != null ? formataData(value.curso_data_certificacao) : 'Cursando';
                        var aluno_qr             = value.aluno_qrcode            != null ? "<a class='btn btn-primary btn-sm' href='/gerar/certificado/"+value.controle_id+'/'+value.aluno_id+'/'+value.curso_id+"'>Imprimir certificado</a>" : "<a class='btn btn-primary btn-sm' href='/gerar/certificado/"+value.controle_id+"'>Gerar certificado</a>";
                        var aluno_contrato       = value.aluno_contrato          != null ? "<a class='btn btn-secondary btn-sm' href='/gerar/certificado/"+value.aluno_contrato+'/'+value.controle_id+'/'+value.aluno_id+'/'+value.curso_id+"'>Imprimir contrato</a>" : "";

                        $("#tabelaCursosVinculados").append('<tr>'+
                                                                '<td>'+'<input type="checkbox" value="'+value.curso_id+'">'+'</td>'+
                                                                '<td>'+value.controle_id+'</td>'+
                                                                '<td>'+value.curso_nome_curso+'</td>'+
                                                                '<td>'+data_inicio_curso+'</td>'+
                                                                '<td>'+data_conclusao_curso+'</td>'+
                                                                '<td>'+data_certificacao+'</td>'+
                                                                '<td>'+aluno_qr+' '+aluno_contrato+'</td>'+
                                                            '</tr>');
                    });
                });
            });
        </script>
    @endsection
@stop