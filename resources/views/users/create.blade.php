@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">
            <h3>Nuevo Usuario</h3>
        </div>

        <div class="card-body">

            <form action="{{ route('users.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}">

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email') }}">

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control">

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>

                    <select
                        name="role"
                        class="form-select">

                        <option value="">Seleccione...</option>

                        @foreach($roles as $role)

                            <option value="{{ $role->name }}">
                                {{ $role->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <button class="btn btn-success">
                    Guardar
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