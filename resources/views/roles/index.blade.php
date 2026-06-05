@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('List of Roles') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('roles.create') }}" class="btn btn-success mb-3">Create a Role</a>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50px">#</th>
                                    <th>Nom  du Role</th>
                                    <th width="250px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $index => $role)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <a href="{{ route('roles.show', $role->id) }}" class="btn btn-info btn-sm">Display</a>
                                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm">Edite</a>
                                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" onsubmit="return confirm('Supprimer ce rôle ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>

                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <small class="text-muted d-block d-md-none mt-2">
                        swipe hotizontally to view all the  colonnes.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection