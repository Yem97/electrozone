@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('create a customer') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('clients.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Formulaire de création du client -->
                    <form method="post" action="{{ route('clients.store') }}">
                        @csrf
                        <div class="form-group mt-2">
                            <label for="client_type">Customer type</label>
                            <select name="client_type" id="client_type" class="form-control">
                                <option value="regular" {{ old('client_type') == 'regular' ? 'selected' : '' }}>Regular Customer</option>
                                <option value="partner" {{ old('client_type') == 'partner' ? 'selected' : '' }}>Partner</option>

                            </select>
                            @error('client_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>




                        <div class="form-group mt-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        

                        <div class="form-group mt-2">
                            <label for="phone_number">Telephone number</label>
                            <input type="tel" name="phone_number" id="phone_number" class="form-control"
                                   pattern="^\+?[0-9]{1,4}?[0-9]{7,15}$"
                                   title="Le numéro de téléphone doit être au format : +1234567890 ou 1234567890"
                                   required>
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="address">Adresse</label>
                            <input type="text" name="address" id="address" class="form-control">
                            @error('address')
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
