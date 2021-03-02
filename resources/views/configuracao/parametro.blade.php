@extends('layouts.main')

@section('content')
    <fieldset class="border p-2">
        <legend class="w-auto">Parâmetros</legend>

        <table id="tabelaPrincipal" class="table table-striped table-bordered " style="width:100%;">
            <thead>
                <tr>
                    <th>Cód.</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Tipo</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $parametros as $parametro )
                    <tr>
                        <td>{{ $parametro->param_cod }}</td>
                        <td>{{ $parametro->param_desc }}</td>

                        @if (strlen($parametro->pv_valor) > 70 )
                            <td>{{ substr($parametro->pv_valor,0,70)."..." }}</td>
                        @else
                            <td>{{ $parametro->pv_valor }}</td>
                        @endif

                        <td>{{ $parametro->param_tipo }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="#" onclick="showModalEditarValorParametro({{$parametro->param_id}})" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
    
    <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Editar parâmetro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

                @if (isset($parametro))
                    <form method="POST" id="formulario" action="">
                        {!! method_field('PUT') !!}
                @endif
                
                @csrf

                <div class="form-group">
                  <label for="message-text" class="col-form-label">Valor:</label>

                    <select class="form-control" id="param_valor_select" name="param_valor_select"></select>

                    <textarea class="form-control" cols='30' rows='10' id="param_valor_text" name="param_valor_text"></textarea>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#tabelaPrincipal').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
                    }
                })
            });

            function showModalEditarValorParametro(param_id){
                param_id = param_id;
                $.get("/configuracao/parametro/"+param_id, function(data){
                    $("#param_valor_select").empty();
                    $("#param_valor_text").empty();
                    $.each(data, function(key, value){
                        if(value.param_tipo == 'STRING'){
                            $("#param_valor_select").css('display', 'none');
                            $("#param_valor_text").css('display', 'block');
                            $("#param_valor_text").append(value.pv_valor);
                            $("#formulario").attr("action", "/configuracao/parametro/"+value.pv_id);
                        }else if (value.param_tipo == 'BOOLEAN'){
                            $("#param_valor_text").css('display', 'none');
                            $("#param_valor_select").css('display', 'block');
                            $("#param_valor_select").append('<option value="true">true</option><option value="false">false</option>');                        
                            $("#formulario").attr("action","/configuracao/parametro/"+value.pv_id);                        
                        }else if (value.param_tipo == 'LISTA'){
                            $("#param_valor_text").css('display', 'none');
                            $("#param_valor_select").css('display', 'block');
                            $("#param_valor_select").append('<option value="Rui">Rui</option><option value="Patrícia">Patrícia</option>');                        
                            $("#formulario").attr("action", "/configuracao/parametro/"+value.pv_id);
                        }                        
                    });
                });
            }
        </script>
    @endsection
@stop