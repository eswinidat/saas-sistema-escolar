@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-sm-6">
            <h1 class="m-0">
                Dashboard
            </h1>
        </div>

    </div>

    <div class="row">

        <!-- Colegios -->

        <div class="col-lg-3 col-6">

            <div class="small-box text-bg-primary">

                <div class="inner">

                    <h3>{{ $totalSchools }}</h3>

                    <p>Colegios Registrados</p>

                </div>

                <div class="small-box-icon">
                    <i class="bi bi-buildings"></i>
                </div>

                <a href="{{ route('schools.index') }}"
                   class="small-box-footer">

                    Ver Colegios
                    <i class="bi bi-arrow-right-circle"></i>

                </a>

            </div>

        </div>

        <!-- Usuarios -->

        <div class="col-lg-3 col-6">

            <div class="small-box text-bg-success">

                <div class="inner">

                    <h3>0</h3>

                    <p>Usuarios</p>

                </div>

                <div class="small-box-icon">
                    <i class="bi bi-people"></i>
                </div>

                <a href="#"
                   class="small-box-footer">

                    Próximamente
                    <i class="bi bi-arrow-right-circle"></i>

                </a>

            </div>

        </div>

        <!-- Estudiantes -->

        <div class="col-lg-3 col-6">

            <div class="small-box text-bg-warning">

                <div class="inner">

                    <h3>0</h3>

                    <p>Estudiantes</p>

                </div>

                <div class="small-box-icon">
                    <i class="bi bi-mortarboard"></i>
                </div>

                <a href="#"
                   class="small-box-footer">

                    Próximamente
                    <i class="bi bi-arrow-right-circle"></i>

                </a>

            </div>

        </div>

        <!-- Docentes -->

        <div class="col-lg-3 col-6">

            <div class="small-box text-bg-danger">

                <div class="inner">

                    <h3>0</h3>

                    <p>Docentes</p>

                </div>

                <div class="small-box-icon">
                    <i class="bi bi-person-workspace"></i>
                </div>

                <a href="#"
                   class="small-box-footer">

                    Próximamente
                    <i class="bi bi-arrow-right-circle"></i>

                </a>

            </div>

        </div>

    </div>

</div>

@endsection