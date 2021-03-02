@extends('layouts.main')

@section('content')
    <fieldset class="border p-2">
        <legend class="w-auto">Lista de Equipamentos</legend>

        <table id="tabelaPrincipal" class="table table-striped table-bordered " style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $equipamentos as $equipamento )
                    <tr>
                        <td>{{ $equipamento->equip_id }}</td>
                        <td>{{ $equipamento->equip_desc }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route("editar.equipamentos", $equipamento->equip_id) }}">Editar</a>
                            <a class="btn btn-danger btn-sm" href="{{ route("editar.equipamentos", $equipamento->equip_id) }}">Excluir</a>
                        </td>
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