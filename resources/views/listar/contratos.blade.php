@extends('layouts.main')

@section('content')
    <fieldset class="border p-2">
        <legend class="w-auto">Lista de Contratos</legend>

        <table id="tabelaPrincipal" class="table table-striped table-bordered " style="width:100%;">
            <thead>
                <tr>
                    <th>Núm. Contrato</th>
                    <th>Aluno</th>
                    <th>Curso</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $contratos as $contrato )
                    <tr>
                        <td><a href="{{ $contrato->cont_id }}">{{ $contrato->cont_id }}</a></td>
                        <td>{{ $contrato->aluno_nome }}</td>
                        <td>{{ $contrato->curso_nome_curso }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route("editar.contrato", $contrato->cont_id) }}">Editar</a>
                            <a class="btn btn-danger btn-sm" href="{{ route("editar.contrato", $contrato->cont_id) }}">Cancelar</a>
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