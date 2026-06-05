@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">{{ __('User Details') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('users.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Informations utilisateur -->
                    <div class="mb-3">
                        <strong>Name :</strong> <span class="ms-1">{{ $user->name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Email :</strong> <span class="ms-1">{{ $user->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
