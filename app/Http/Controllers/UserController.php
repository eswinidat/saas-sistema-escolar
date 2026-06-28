<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Mostrar listado.
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
            $roles = Role::orderBy('name')->get();

            return view('users.create', compact('roles'));
    }

    /**
     * Guardar usuario.
     */
public function store(StoreUserRequest $request)
{
    $user = User::create([

        'name' => $request->name,

        'email' => $request->email,

        'password' => Hash::make($request->password),

    ]);

    $user->assignRole($request->role);

    return redirect()
            ->route('users.index')
            ->with('success', 'Usuario registrado correctamente.');
}

    /**
     * Mostrar usuario.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(User $user)
    {
            $roles = Role::orderBy('name')->get();

            return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar usuario.
     */
public function update(UpdateUserRequest $request, User $user)
{
    $data = [

        'name' => $request->name,

        'email' => $request->email,

    ];

    if ($request->filled('password')) {

        $data['password'] = Hash::make($request->password);

    }

    $user->update($data);

    $user->syncRoles([$request->role]);

    return redirect()
            ->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
}

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user)
    {
        // Evitar eliminar al usuario que está logueado
    if ($user->id == auth()->id()) {

        return redirect()
            ->route('users.index')
            ->with('success', 'No puedes eliminar tu propio usuario.');

    }

    $user->delete();

    return redirect()
            ->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');

    }
}