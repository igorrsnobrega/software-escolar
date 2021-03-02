@extends('layouts.main')

@section('content')
    <fieldset class="border p-2">
        <legend class="w-auto">Lista de Alunos</legend>

        <table id="tabelaPrincipal" class="table table-striped table-bordered " style="width:100%;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $alunos as $aluno )
                    <tr>
                        <td>{{ $aluno->aluno_id }}</td>
                        <td><a href="#" onclick="abrirPopup('/dados/alunos/' + {{$aluno->aluno_id}}, 500, 500)" class="aluno_id">{{ $aluno->aluno_nome }}</a> </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route("editar.alunos", $aluno->aluno_id) }}">Editar</a>
                            <a class="btn btn-danger btn-sm" href="{{ route("editar.alunos", $aluno->aluno_id) }}">Excluir</a>
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