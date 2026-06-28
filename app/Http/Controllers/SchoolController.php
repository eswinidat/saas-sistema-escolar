<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;

class SchoolController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $schools = School::orderBy('id', 'desc')->paginate(10);

        return view('schools.index', compact('schools'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Guardar colegio.
     */
    public function store(StoreSchoolRequest $request)
    {
        School::create($request->validated());

        return redirect()
            ->route('schools.index')
            ->with('success', 'Colegio registrado correctamente.');
    }

    /**
     * Mostrar un colegio.
     */
    public function show(School $school)
    {
        return view('schools.show', compact('school'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    /**
     * Actualizar colegio.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->update($request->validated());

        return redirect()
            ->route('schools.index')
            ->with('success', 'Colegio actualizado correctamente.');
    }

    /**
     * Eliminar colegio.
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()
            ->route('schools.index')
            ->with('success', 'Colegio eliminado correctamente.');
    }
}