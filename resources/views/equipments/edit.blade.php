@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Edite Item') }}</div>

                <div class="card-body">
                    <a href="{{ route('equipments.index') }}" class="btn btn-info mb-3">Retour</a>

                    <form method="post" action="{{ route('equipments.update', $equipment->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Item name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $equipment->name) }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Actual quantity</label>
                            <input type="number" class="form-control" value="{{ $equipment->initial_quantity }}" disabled>
                        </div>
                            {{-- Choix de l'action sur la quantité --}}
                        <div class="mb-3">
                            <label class="form-label">Action on quantity :</label>
                            <select name="quantity_action" id="quantity_action" class="form-select">
                                <option value="">-- Choisir une action --</option>
                                <option value="add">Add to the exsisting quantity</option>
                                <option value="replace">Replace quantity</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="add_quantity_field">
                            <label for="add_quantity" class="form-label">Quantité à ajouter</label>
                            <input type="number" name="add_quantity" id="add_quantity" class="form-control" min="0">
                            @error('add_quantity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        @can('user-list')
                        <div class="mb-3 d-none" id="new_quantity_field">
                            <label for="new_quantity" class="form-label">New quantity</label>
                            <input type="number" name="new_quantity" id="new_quantity" class="form-control" min="0">
                            @error('new_quantity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        @endcan

                        <div class="mb-3">
                            <label for="unit_price" class="form-label">Unite price (FCFA)</label>
                            <input type="number" id="unit_price" name="unit_price" step="0.01" class="form-control" value="{{ old('unit_price', $equipment->unit_price) }}">
                            @error('unit_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="partner_unit_price" class="form-label"> Partner Unite price  (FCFA)</label>
                            <input type="number" step="0.01" id="partner_unit_price" name="partner_unit_price" class="form-control"
                                value="{{ old('partner_unit_price', $equipment->partner_unit_price) }}">
                            @error('partner_unit_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Add Category Dropdown -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Item Category</label>
                            <select id="category_id" name="category_id" class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $equipment->category_id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">ActualImage</label><br>

                            @if($equipment->image)
                                <img src="{{ asset('storage/' . $equipment->image) }}"
                                    alt="{{ $equipment->name }}"
                                    class="mb-2 rounded img-thumbnail"
                                    style="max-width: 200px; height: auto;">
                            @else
                                <p class="text-muted">NO image register.</p>
                            @endif

                            <input type="file" name="image" id="image" class="form-control mt-2">

                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-success w-100">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const actionSelect = document.getElementById('quantity_action');
        const addField = document.getElementById('add_quantity_field');
        const newField = document.getElementById('new_quantity_field');

        actionSelect.addEventListener('change', function () {
            if (this.value === 'add') {
                addField.classList.remove('d-none');
                newField.classList.add('d-none');
            } else if (this.value === 'replace') {
                newField.classList.remove('d-none');
                addField.classList.add('d-none');
            } else {
                addField.classList.add('d-none');
                newField.classList.add('d-none');
            }
        });
    });
</script>
@endsection
