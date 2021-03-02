@extends('layouts.main')

@section('content')
    <fieldset class="border p-2">
        <legend class="w-auto">Lista de acessos</legend>

        <table id="tabelaPrincipal" class="table table-striped table-bordered " style="width:100%;">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Máquina</th>
                    <th>Hora e data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $ultimosAcessos as $ultimoAcesso )
                    <tr>
                        <td>{{ $ultimoAcesso->login_nome }}</td>
                        <td>{{ $ultimoAcesso->login_maquina }}</td>
                        <td>{{ $ultimoAcesso->date_insert }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </fieldset>
    
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#tabelaPrincipal').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
                    }
                })
            });
        </script>
    @endsection
@stop