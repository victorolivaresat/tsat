<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Response;
use Inertia\Inertia;

// Models
use App\Models\Role;
use App\Models\Module;

class RolesController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Roles/Index', [
            'filters' => Request::all(['search']),
            'roles' => Role::orderBy('name')
                ->filter(Request::only(['search']))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($role) => [
                    'id' => $role->id,
                    'slug' => $role->slug,
                    'name' => $role->name,
                    'created_at' => $role->created_at->diffForHumans(),
                ]),
        ]);
    }

    // Mostrar formulario de creación de rol
    public function create(): Response
    {
        $modules = Module::with('permissions')->get();

        return Inertia::render('Roles/Create', [
            'modules' => $modules,
        ]);
    }

    // Guardar un nuevo rol en la base de datos
    public function store(): RedirectResponse
    {
        Request::validate([
            'slug' => ['required', 'max:50', 'unique:roles'],
            'name' => ['required', 'max:50'],
            'permissions' => ['required', 'array'],
        ]);

        $role = Role::create([
            'slug' => Request::get('slug'),
            'name' => Request::get('name'),
        ]);

        $role->permissions()->sync(Request::get('permissions'));

        return Redirect::route('roles')->with('success', 'Role created.');
    }

    // Mostrar formulario de edición de rol
    public function edit(Role $role): Response
    {
        $modules = Module::with('permissions')->get();

        return Inertia::render('Roles/Edit', [
            'role' => [
                'id' => $role->id,
                'slug' => $role->slug,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('id')->toArray(),
            ],
            'modules' => $modules,
        ]);
    }

    // Actualizar rol existente en la base de datos
    public function update(Role $role): RedirectResponse
    {
        Request::validate([
            'slug' => ['required', 'max:50', Rule::unique('roles')->ignore($role->id)],
            'name' => ['required', 'max:50'],
            'permissions' => ['required', 'array'],
        ]);

        $role->update([
            'slug' => Request::get('slug'),
            'name' => Request::get('name'),
        ]);

        $role->permissions()->sync(Request::get('permissions'));

        return Redirect::back()->with('success', 'Role updated.');
    }

    // Eliminar un rol
    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return Redirect::back()->with('success', 'Role deleted.');
    }

}
