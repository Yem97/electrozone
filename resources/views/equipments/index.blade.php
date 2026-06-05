@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Equipements') }}</div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <!-- Filter & Search Form -->
                    <form method="GET" action="{{ route('equipments.index') }}" class="mb-4 d-flex flex-wrap align-items-end">
                        <div class="me-3 mb-2">
                            <label for="category" class="form-label">Catégorie</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">All categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="me-3 mb-2">
                            <label for="search" class="form-label">Search by name</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Nom de l’équipement">
                        </div>

                        <div class="mb-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Réinitialiser</a>
                             <a href="{{ route('equipments.catalog.download') }}" class="btn btn-primary">
                                📄 Downlaod catalogue
                            </a>
                        </div>
                    </form>

                    <a href="{{ route('equipments.create') }}" class="btn btn-success mb-3">Create Item</a>
                   


                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Categorie</th> <!-- Added Category column -->
                                    <th>Initial quantity</th>
                                    <th>Avialable</th>
                                    <th>Reserved</th>
                                    <th>Used</th>
                                    <th>Returned</th>
                                    <th>Missing</th>
                                    <th>U.Price (FCFA)</th>
                                    <th>U.Price Partenaire (FCFA)</th>

                                    
                                    <th>Code</th>
                                    <th>create the</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipments as $index => $equipment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                       <td>
                                            @if ($equipment->image)
                                                <img src="{{ asset('storage/' . $equipment->image) }}"
                                                    alt="{{ $equipment->name }}"
                                                    style="max-width: 50px; height: auto;"
                                                    class="rounded img-thumbnail">

                                            @else
                                                <span class="text-muted">None</span>
                                            @endif
                                        </td>


                                        <td>{{ $equipment->name }}</td>
                                        <td>{{ $equipment->category ? $equipment->category->name : 'None categorie' }}</td> <!-- Display category name -->
                                        <td>{{ $equipment->initial_quantity }}</td>
                                        <td>{{ $equipment->available_quantity }}</td>
                                        <td>{{ $equipment->reserved_quantity }}</td>
                                        <td>{{ $equipment->used_quantity }}</td>
                                        <td>{{ $equipment->returned_quantity }}</td>
                                        <td>
                                            {{ max($equipment->used_quantity - $equipment->returned_quantity, 0) }}
                                        </td>
                                        <td>{{ number_format($equipment->unit_price, 0, ',', ' ') }}</td>
                                        <td>{{ number_format($equipment->partner_unit_price, 0, ',', ' ') }}</td>
                                        <td>{{ $equipment->unic_code }}</td>
                                        <td>{{ $equipment->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('equipments.destroy', $equipment->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('equipments.show', $equipment->id) }}" class="btn btn-info btn-sm">Voir</a>
                                                <a href="{{ route('equipments.edit', $equipment->id) }}" class="btn btn-primary btn-sm">Edite</a>
                                                @can('equipment-delete')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">No Item found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div> <!-- End table-responsive -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
