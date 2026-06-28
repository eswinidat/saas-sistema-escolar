@extends('layouts.admin')

@section('content')

<x-page-header :title="$title">
    <x-slot:subtitle>
        Seleccione un colegio en la barra superior para administrar la configuración y matrícula.
    </x-slot:subtitle>
</x-page-header>

<x-alert />

<x-card title="Colegio no seleccionado">
    <p class="mb-0">
        Como Super Administrador debe elegir el colegio con el que desea trabajar.
        Use el selector en la barra de navegación o registre un colegio primero.
    </p>

    @role('Super Administrador')
        <div class="mt-3">
            <a href="{{ route('schools.index') }}" class="btn btn-primary">
                <i class="bi bi-building me-1"></i> Gestionar colegios
            </a>
        </div>
    @endrole
</x-card>

@endsection
