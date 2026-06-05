@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Categorie Details') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('categories.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Détails de la catégorie -->
                    <div class="mb-3">
                        <!-- Nom de la catégorie -->
                        <div class="d-flex flex-column flex-md-row mb-2">
                            <strong class="me-md-2">Catedory name :</strong>
                            <span>{{ $category->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
