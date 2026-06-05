@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Create an Item') }}</div>

                <div class="card-body">
                    {{-- Message de succès --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Message d'erreur --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Retour à la gestion des équipements --}}
                    <a href="{{ route('equipments.index') }}" class="btn btn-info mb-3">Return</a>

                    <form method="post" action="{{ route('equipments.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categorie</label>
                            <select id="category_id" name="category_id" class="form-control">
                                <option value="">Select a categorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Item name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        

                        <div class="mb-3">
                            <label for="initial_quantity" class="form-label">Initial quantity</label>
                            <input type="number" id="initial_quantity" name="initial_quantity" class="form-control" value="{{ old('initial_quantity') }}">
                            @error('initial_quantity')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_price" class="form-label">Unite price (FCFA)</label>
                            <input type="number" id="unit_price" name="unit_price" step="0.01" class="form-control" value="{{ old('unit_price') }}">
                            @error('unit_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="partner_unit_price" class="form-label">Partner unite price (FCFA)</label>
                            <input type="number" step="0.01" id="partner_unit_price" name="partner_unit_price" class="form-control"
                                value="{{ old('partner_unit_price') }}">
                            @error('partner_unit_price')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="image" class="form-label">Item Image</label>
                            <input type="file" id="image" name="image" class="form-control">
                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
