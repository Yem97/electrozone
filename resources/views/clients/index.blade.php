@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">{{ __('Customers list') }}</div>

                <div class="card-body">
                    @session("success")
                        <div class="alert alert-success">{{ $value }}</div>
                    @endsession

                    <a href="{{ route('clients.create') }}" class="btn btn-success mb-3">Create Customer</a>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                   <th style="width: 20px;">#</th>
                                   <th style="width: 200px;">Name</th>
                                   <th style="width: 20px;">Customer type</th>
                                   <th style="width: 15px;">Telephone</th>
                                   <th style="width: 25px;">Adresse</th>
                                   <th style="width: 50px;">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $index => $client)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $client->name }}</td>
                                        <td>
                                            @if($client->client_type === 'partner')
                                                <span class="badge bg-success">Partner</span>
                                            @else
                                                <span class="badge bg-secondary">regular customer</span>
                                            @endif
                                        </td>
                                        <td>{{ $client->phone_number }}</td>
                                        <td>{{ $client->address }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('clients.destroy', $client->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <div class="d-flex flex-wrap gap-1">
                                                    <a href="{{ route('clients.show', $client->id) }}" class="btn btn-info btn-sm">Display</a>
                                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary btn-sm">Modified</a>
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- table-responsive -->

                    <!-- Optional: hint for mobile users -->
                    <small class="text-muted d-block d-md-none mt-2">
                        Swipe to your right to see more colomns.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
