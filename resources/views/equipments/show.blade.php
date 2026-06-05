@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('see Item') }}</div>

                <div class="card-body">
                    <a href="{{ route('equipments.index') }}" class="btn btn-info mb-3">Retour</a>

                    <div class="mb-2">
                        <strong>ID :</strong>
                        <span class="ms-1">{{ $equipment->id }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>Name :</strong>
                        <span class="ms-1">{{ $equipment->name }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>Unique code :</strong>
                        <span class="ms-1">{{ $equipment->unit_code }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>Initial quantity :</strong>
                        <span class="ms-1">{{ $equipment->initial_quantity }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>available quantity :</strong>
                        <span class="ms-1">{{ $equipment->available_quantity }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>reserved quantity :</strong>
                        <span class="ms-1">{{ $equipment->reserved_quantity }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>Used quantity :</strong>
                        <span class="ms-1">{{ $equipment->used_quantity }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>Reterned quantity :</strong>
                        <span class="ms-1">{{ $equipment->returned_quantity }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>Unite Price :</strong>
                        <span class="ms-1">{{ number_format($equipment->unit_price, 0, ',', ' ') }} FCFA</span>
                    </div>
                     <div class="mb-2">
                        <strong>Unite price Partenaire :</strong>
                        <span class="ms-1">{{ number_format($equipment->partner_unit_price, 0, ',', ' ') }} FCFA</span>
                    </div>

                    <div class="mb-2">
                        <strong>Add this :</strong>
                        <span class="ms-1">{{ $equipment->created_at->format('Y-m-d') }}</span>
                    </div>

                    <div class="mb-2">
                        <strong>last Modification :</strong>
                        <span class="ms-1">{{ $equipment->updated_at->format('Y-m-d') }}</span>
                    </div>

                    <div class="mb-2"> 
                        <strong>Image :</strong><br>
                        @if($equipment->image)
                            <img src="{{ asset('storage/' . $equipment->image) }}"
                                alt="{{ $equipment->name }}"
                                style="max-width: 200px; height: auto;"
                                class="rounded img-thumbnail">

                        @else
                            <span class="text-muted">No image</span>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
