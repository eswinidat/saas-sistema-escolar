@extends('layouts.admin')

@section('content')

<div class="card card-warning">

    <div class="card-header">
        <h3 class="card-title">Editar Colegio</h3>
    </div>

    <form action="{{ route('schools.update', $school) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Se encontraron errores:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <h5 class="mb-3">Información General</h5>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre del Colegio</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $school->name) }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Código</label>

                    <input
                        type="text"
                        name="code"
                        class="form-control"
                        value="{{ old('code', $school->code) }}">
                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">RUC</label>

                    <input
                        type="text"
                        name="ruc"
                        maxlength="11"
                        class="form-control"
                        value="{{ old('ruc', $school->ruc) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Código Modular</label>

                    <input
                        type="text"
                        name="modular_code"
                        class="form-control"
                        value="{{ old('modular_code', $school->modular_code) }}">
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Información de Contacto</h5>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Teléfono</label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        value="{{ old('phone', $school->phone) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Correo Electrónico</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $school->email) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Sitio Web</label>

                    <input
                        type="url"
                        name="website"
                        class="form-control"
                        value="{{ old('website', $school->website) }}">
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Ubicación</h5>

            <div class="mb-3">
                <label class="form-label">Dirección</label>

                <input
                    type="text"
                    name="address"
                    class="form-control"
                    value="{{ old('address', $school->address) }}">
            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="form-label">Distrito</label>

                    <input
                        type="text"
                        name="district"
                        class="form-control"
                        value="{{ old('district', $school->district) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Provincia</label>

                    <input
                        type="text"
                        name="province"
                        class="form-control"
                        value="{{ old('province', $school->province) }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Departamento</label>

                    <input
                        type="text"
                        name="department"
                        class="form-control"
                        value="{{ old('department', $school->department) }}">
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Administración</h5>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Director(a)</label>

                    <input
                        type="text"
                        name="principal_name"
                        class="form-control"
                        value="{{ old('principal_name', $school->principal_name) }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Estado</label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="1" {{ old('status', $school->status) ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="0" {{ !old('status', $school->status) ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>
                </div>

            </div>

        </div>

        <div class="card-footer">

            <button
                class="btn btn-warning"
                type="submit">

                Actualizar Colegio

            </button>

            <a
                href="{{ route('schools.index') }}"
                class="btn btn-secondary">

                Cancelar

            </a>

        </div>

    </form>

</div>

@endsection