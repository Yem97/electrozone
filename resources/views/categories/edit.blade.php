@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Edite Categorie') }}</div>

                <div class="card-body">
                    <!-- Retour -->
                    <a href="{{ route('categories.index') }}" class="btn btn-info mb-3">Retour</a>

                    <!-- Formulaire de mise à jour de la catégorie -->
                    <form method="post" action="{{ route('categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Nom de la catégorie -->
                        <div class="form-group mt-2">
                            <label for="name">CatEgorie Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success w-100 w-md-auto">Mettre à jour</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
