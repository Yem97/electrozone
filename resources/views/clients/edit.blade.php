@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Edite client') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('clients.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Formulaire de mise à jour -->
                    <form method="post" action="{{ route('clients.update', $client->id) }}">
                        @csrf
                        @method('PUT')
                     <div class="form-group mt-2">
                        <label for="client_type">Customer type</label>
                        <select name="client_type" id="client_type" class="form-control">
                            <option value="">-- Select --</option>
                            <option value="regular" {{ old('client_type', $client->client_type) == 'regular' ? 'selected' : '' }}>Regular customer</option>
                            <option value="partner" {{ old('client_type', $client->client_type) == 'partner' ? 'selected' : '' }}>Partner</option>
                        </select>
                        @error('client_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>




                        <div class="form-group mt-2">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $client->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                      

                        <div class="form-group mt-2">
                            <label for="phone_number">Telephone number</label>
                            <input type="tel" name="phone_number" id="phone_number" class="form-control"
                                   value="{{ $client->phone_number }}"
                                   pattern="^\+?[0-9]{1,4}?[0-9]{7,15}$"
                                   title="Le numéro de téléphone doit être au format : +1234567890 ou 1234567890"
                                   required>
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mt-2">
                            <label for="address">Adresse</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{ $client->address }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success w-100 w-md-auto">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
