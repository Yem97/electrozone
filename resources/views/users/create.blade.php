@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Create a user') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('users.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Formulaire de création d'utilisateur -->
                    <form method="post" action="{{ route('users.store') }}">
                        @csrf

                        <div class="mt-2">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <label>Password Confirmation</label>
                            <input type="password" name="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Roles</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($roles as $role)
                                    @if(
                                        !in_array($role->name, ['Super Admin', 'Admin']) 
                                        || auth()->user()->hasRole('Super Admin')
                                    )
                                        <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                class="form-check-input" 
                                                name="roles[]" 
                                                id="role_{{ $role->id }}" 
                                                value="{{ $role->name }}"
                                                {{ isset($user) && $user->hasRole($role->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>


                        <div class="mt-4">
                            <button class="btn btn-success">Create</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
