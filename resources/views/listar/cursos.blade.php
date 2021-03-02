@extends('layouts.main')

@section('content')
    <fieldset class="border p-2">
        <legend class="w-auto">Lista de Cursos</legend>

        <table id="tabelaPrincipal" class="table table-striped table-bordered " style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Carga horária</th>
                    <th>Status</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $cursos as $curso )
                    <tr>
                        <td>{{ $curso->curso_id }}</td>
                        <td>{{ $curso->curso_nome_curso }}</td>
                        <td>{{ $curso->curso_cargaHoraria }}</td>
                        <td>{{ $curso->curso_ativo }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route("editar.cursos", $curso->curso_id) }}">Editar</a>
                            <a class="btn btn-danger btn-sm" href="{{ route("editar.cursos", $curso->curso_id) }}">Excluir</a>
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