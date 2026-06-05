@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Liste of Categories') }}</div>

                <div class="card-body">
                    <!-- Affichage du message de succès -->
                    @if(session("success"))
                        <div class="alert alert-success">{{ session("success") }}</div>
                    @endif

                    <!-- Bouton pour créer une nouvelle catégorie -->
                    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Create a Categorie</a>
                    
                    <!-- Table des catégories -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 100px;">#</th>
                                    <th>Categorie Name</th>
                                    <th style="width: 350px;">Actions</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($categories as $index => $category)
                                    <tr>
                                        <td>{{ $index + 1  }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <!-- Formulaire pour supprimer une catégorie -->
                                            <form method="POST" action="{{ route('categories.destroy', $category->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex flex-wrap gap-1">
                                                    <!-- Actions -->
                                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">Afficher</a>
                                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->

                    <!-- Astuce pour les utilisateurs mobiles -->
                    <small class="text-muted d-block d-md-none mt-2">
                        Swipe right to see more colomns.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
