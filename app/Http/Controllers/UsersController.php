<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

// Models
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Users/Index', [
            'filters' => Request::all(['search', 'trashed']),
            'users' => User::orderByName()
                ->filter(Request::only(['search', 'trashed']))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 50, 'fit' => 'crop']) : null,
                    'deleted_at' => $user->deleted_at,
                    'roles' => $user->roles()->pluck('name'),
                    'status' => $user->status,
                    'created_at' => $user->created_at->diffForHumans(),
                ]),
        ]);
    }

    public function create(): Response
    {
        $roles = Role::all(['name', 'id']);

        return Inertia::render('Users/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(): RedirectResponse
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user = User::create([
            'first_name' => Request::get('first_name'),
            'last_name' => Request::get('last_name'),
            'email' => Request::get('email'),
            'password' => Request::get('password'),
            'photo_path' => Request::file('photo') ? Request::file('photo')->store('users') : null,
        ]);

        $user->roles()->attach(Request::get('roles'));

        return Redirect::route('users')->with('success', 'User created.');
    }

    public function edit(User $user): Response
    {
        $roles = Role::orderBy('name')->get(['id', 'name']);
        
        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'owner' => $user->owner,
                'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
                'deleted_at' => $user->deleted_at,
                'roles' => $user->roles()->pluck('id')->toArray(),
            ],
            'roles' => $roles
        ]);
    }

    public function update(User $user): RedirectResponse
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable'],
            'photo' => ['nullable', 'image'],
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $user->update(Request::only(['first_name', 'last_name', 'email']));
        $user->roles()->sync(Request::input('roles'));

        if (Request::file('photo')) {
            $user->update(['photo_path' => Request::file('photo')->store('users')]);
        }

        if (Request::get('password')) {
            $user->update(['password' => Request::get('password')]);
        }

        return Redirect::back()->with('success', 'User updated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if($user->id == 1) {
            return Redirect::back()->with('error', 'The admin user cannot be deleted.');
        }
        
        $user->delete();

        return Redirect::back()->with('success', 'User deleted.');
    }

    public function restore(User $user): RedirectResponse
    {
        $user->restore();

        return Redirect::back()->with('success', 'User restored.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $user->status = !$user->status;
        $user->save();

        return Redirect::back()->with('success', 'User status updated.');
    }
}
