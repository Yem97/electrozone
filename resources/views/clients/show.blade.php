@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Customer details') }}</div>

                <div class="card-body">
                    <a href="{{ route('clients.index') }}" class="btn btn-info mb-3">Return</a>

                    <div class="mb-3">
                        <div class="d-flex flex-column flex-md-row mb-2">
                            <strong class="me-md-2">Name :</strong>
                            <span>{{ $client->name }}</span>
                        </div>
                         <div class="d-flex flex-column flex-md-row mb-2">
                            <strong class="me-md-2">Type de client :</strong>
                            <span>
                                @if($client->client_type === 'partner')
                                    Partner
                                @else
                                    Rugular customer
                                @endif
                            </span>
                        </div>


                      

                        <div class="d-flex flex-column flex-md-row mb-2">
                            <strong class="me-md-2">Telephone number:</strong>
                            <span>{{ $client->phone_number }}</span>
                        </div>

                        <div class="d-flex flex-column flex-md-row">
                            <strong class="me-md-2">Adresse :</strong>
                            <span>{{ $client->address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
