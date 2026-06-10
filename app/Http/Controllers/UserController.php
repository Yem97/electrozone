<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:user-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:user-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:user-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:user-delete'],["only" =>["destroy"]]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Si l'utilisateur connecté N'EST PAS Super Admin, on exclut les Super Admins
        if (!auth()->user()->hasRole('Super Admin')) {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Super Admin');
            })->get();
        } else {
            $users = User::all();
        }
    
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view("users.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'roles' => 'required|array',
        'roles.*' => 'string|exists:roles,name'
    ]);

    if ($validated->fails()) {
        return response()->json(['errors' => $validated->errors()], 403);
    }

    // 🔒 Only a Super Admin can grant the Admin or Super Admin role to anyone.
    // (Mirrors the checkbox visibility in users/create.blade.php, but enforced
    // server-side so it can't be bypassed with a raw POST.)
    if (
        array_intersect(['Admin', 'Super Admin'], $request->roles)
        && !auth()->user()->hasRole('Super Admin')
    ) {
        return response()->json(['error' => 'Only a Super Admin can assign the Admin or Super Admin role.'], 403);
    }

    try {
        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 🛡 Attribuer les rôles via le guard sanctum
        $roles = Role::whereIn('name', $request->roles)
                     ->where('guard_name', 'sanctum')
                     ->pluck('name')
                     ->toArray();

        $user->syncRoles($roles);

        // Créer un token
        $user->createToken('auth_token')->plainTextToken;

        return redirect()->route("users.index")->with("success", "Utilisateur créé avec succès.");
        
    } catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 403);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        return view("users.show", compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        $roles= Role::all();
        return view("users.edit", compact("user", "roles"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validate input
        $validated = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:6|confirmed', 
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name'       
        ]);

        if ($validated->fails()) {
            return response()->json(data: $validated->errors(),status:403);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $actingUser = auth()->user();
        $isSelf = $actingUser->id === $user->id;
        $actingIsSuperAdmin = $actingUser->hasRole('Super Admin');
        $targetIsElevated = $user->hasRole('Admin') || $user->hasRole('Super Admin');
        $requestingElevatedRole = (bool) array_intersect(['Admin', 'Super Admin'], $request->roles);

        // 🔒 Server-side mirror of the role-hierarchy rules already encoded in
        // resources/views/users/index.blade.php and users/edit.blade.php.
        // The UI hides buttons/checkboxes for non-Super-Admins, but that alone
        // doesn't stop a direct PATCH request — enforce it here too.
        if (!$actingIsSuperAdmin) {
            // Admins may only edit plain Users, or themselves.
            if ($targetIsElevated && !$isSelf) {
                return response()->json(['error' => 'Only a Super Admin can modify other Admin or Super Admin accounts.'], 403);
            }

            // Admins can never grant the Admin or Super Admin role, even to themselves.
            if ($requestingElevatedRole) {
                return response()->json(['error' => 'Only a Super Admin can assign the Admin or Super Admin role.'], 403);
            }
        }

       try {
         // 🛡 Attribuer les rôles via le guard sanctum
         $roles = Role::whereIn('name', $request->roles)
         ->where('guard_name', 'sanctum')
         ->pluck('name')
         ->toArray();

        $user->syncRoles($roles);

        $user->name = $request->name;
        $user->email = $request->email;

        // Only touch the password if a new one was actually provided.
        // It's validated as nullable; Hash::make('') would otherwise
        // overwrite (and break) the user's existing password on every edit.
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route("users.index")->with("success","User updated.");


        } catch (\Exception $exception) {
         return response()->json(data:['error' => $exception->getMessage()],status:403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        $actingUser = auth()->user();

        // 🔒 Never allow deleting your own account from this screen.
        if ($actingUser->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        // 🔒 Server-side mirror of users/index.blade.php: only a Super Admin
        // can delete an Admin or Super Admin account.
        if (!$actingUser->hasRole('Super Admin') && ($user->hasRole('Admin') || $user->hasRole('Super Admin'))) {
            return redirect()->route('users.index')->with('error', 'Only a Super Admin can delete Admin or Super Admin accounts.');
        }

        // 🔒 Never delete the last remaining Super Admin — that would lock
        // role/permission management for everyone.
        if ($user->hasRole('Super Admin') && User::role('Super Admin')->count() <= 1) {
            return redirect()->route('users.index')->with('error', 'Cannot delete the last remaining Super Admin.');
        }

        $user->delete();
        return redirect()->route("users.index")->with("success","User deleted.");
    }
}
