@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Users') }}</div>

                <div class="card-body">

                    @session("success")
                        <div class="alert alert-success">{{ $value }}</div>
                    @endsession

                    <!-- Bouton pour créer un nouvel utilisateur -->
                     @can('user-create')
                    <a href="{{ route('users.create') }}" class="btn btn-success mb-3">
                        Create a user
                    </a>
                    @endcan

                    <!-- Tableau des utilisateurs -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->getRoleNames() as $role)
                                            <button class="btn btn-success btn-sm">{{ $role }}</button>
                                            @endforeach
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <!-- Always allow viewing -->
                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Voir</a>

                                                @php
                                                    $isSelf = auth()->id() === $user->id;
                                                    $currentUser = auth()->user();
                                                    $currentIsSuperAdmin = $currentUser->hasRole('Super Admin');
                                                    $currentIsAdmin = $currentUser->hasRole('Admin');
                                                    $targetIsAdmin = $user->hasRole('Admin') || $user->hasRole('Super Admin');
                                                @endphp

                                                @if(
                                                    $currentIsSuperAdmin || // Super Admin can do anything
                                                    ($currentIsAdmin && (!$targetIsAdmin || $isSelf)) // Admin can edit/delete others except Admin/Super Admin, and can edit self
                                                )
                                                    <!-- Show edit button -->
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edite</a>

                                                    <!-- Show delete if not self -->
                                                    @if(!$isSelf)
                                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                                            Supprimer
                                                        </button>
                                                    @endif
                                                @endif
                                            </form>



                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
