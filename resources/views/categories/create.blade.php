@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Create a Categorie') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('categories.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Formulaire de création de la catégorie -->
                    <form method="post" action="{{ route('categories.store') }}">
                        @csrf

                        <div class="form-group mt-2">
                            <label for="name">categorie name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100 w-md-auto">Créer</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
