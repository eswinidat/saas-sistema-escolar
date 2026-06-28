@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3>Detalle del Usuario</h3>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="200">ID</th>
                    <td>{{ $user->id }}</td>
                </tr>

                <tr>
                    <th>Nombre</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>Correo</th>
                    <td>{{ $user->email }}</td>
                </tr>

                <tr>
                    <th>Rol</th>
                    <td>

                        @if($user->roles->count())

                            <span class="badge bg-success">
                                {{ $user->roles->first()->name }}
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                Sin Rol
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Fecha de Registro</th>
                    <td>{{ $user->created_at }}</td>
                </tr>

            </table>

            <a href="{{ route('users.index') }}"
               class="btn btn-secondary">

                Volver

            </a>

        </div>

    </div>

</div>

@endsection