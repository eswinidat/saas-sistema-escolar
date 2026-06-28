@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3>Editar Usuario</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('users.update', $user) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Nombre</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}">

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-3">

                    <label>Correo</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}">

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-3">

                    <label>Nueva Contraseña</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                    <small class="text-muted">
                        Déjala vacía si no deseas cambiarla.
                    </small>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-3">

                    <label>Rol</label>

                    <select
                        name="role"
                        class="form-select">

                        @foreach($roles as $role)

                            <option
                                value="{{ $role->name }}"
                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                                {{ $role->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <button class="btn btn-success">
                    Actualizar
                </button>

                <a href="{{ route('users.index') }}"
                   class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

@endsection