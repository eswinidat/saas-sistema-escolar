@extends('layouts.admin')

@section('content')

<div class="card card-info">

    <div class="card-header">
        <h3 class="card-title">
            Información del Colegio
        </h3>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <strong>Nombre:</strong><br>
                {{ $school->name }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Código:</strong><br>
                {{ $school->code ?? '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>RUC:</strong><br>
                {{ $school->ruc ?? '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Código Modular:</strong><br>
                {{ $school->modular_code ?? '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Teléfono:</strong><br>
                {{ $school->phone ?? '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Correo:</strong><br>
                {{ $school->email ?? '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Sitio Web:</strong><br>

                @if($school->website)
                    <a href="{{ $school->website }}" target="_blank">
                        {{ $school->website }}
                    </a>
                @else
                    -
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <strong>Director(a):</strong><br>
                {{ $school->principal_name ?? '-' }}
            </div>

            <div class="col-md-12 mb-3">
                <strong>Dirección:</strong><br>
                {{ $school->address ?? '-' }}
            </div>

            <div class="col-md-4 mb-3">
                <strong>Distrito:</strong><br>
                {{ $school->district ?? '-' }}
            </div>

            <div class="col-md-4 mb-3">
                <strong>Provincia:</strong><br>
                {{ $school->province ?? '-' }}
            </div>

            <div class="col-md-4 mb-3">
                <strong>Departamento:</strong><br>
                {{ $school->department ?? '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Estado:</strong><br>

                @if($school->status)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-danger">Inactivo</span>
                @endif
            </div>

        </div>

    </div>

    <div class="card-footer">

        <a href="{{ route('schools.edit', $school) }}"
           class="btn btn-warning">
            Editar
        </a>

        <a href="{{ route('schools.index') }}"
           class="btn btn-secondary">
            Volver
        </a>

    </div>

</div>

@endsection