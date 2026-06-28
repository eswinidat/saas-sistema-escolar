@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card">

        <div class="card-header">

            <h3>Nuevo Rol</h3>

        </div>

        <div class="card-body">

            <form action="{{ route('roles.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Nombre del Rol

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}">

                    @error('name')

                        <small class="text-danger">

                            {{ $message }}

                        </small>

                    @enderror

                </div>

                <button class="btn btn-success">

                    Guardar

                </button>

                <a href="{{ route('roles.index') }}"
                   class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

@endsection