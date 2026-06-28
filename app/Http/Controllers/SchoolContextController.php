<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolContextController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'school_id' => ['nullable', 'exists:schools,id'],
        ]);

        abort_unless($request->user()?->hasRole('Super Administrador'), 403);

        if ($request->filled('school_id')) {
            $request->session()->put('current_school_id', (int) $request->input('school_id'));
        } else {
            $request->session()->forget('current_school_id');
        }

        return back()->with('success', 'Colegio seleccionado correctamente.');
    }
}
