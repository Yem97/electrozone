@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Edite role') }}</div>

                <div class="card-body">
                    <!-- Bouton retour -->
                    <a href="{{ route('roles.index') }}" class="btn btn-info mb-3">Return</a>

                    <!-- Formulaire de création du client -->
                    <form method="post" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method("PUT")
                        <div class="form-group mt-2">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        
                        <div class="mt-2">
                            <h3>Permissions :</h3>
                            <!-- Select All Checkbox -->
                            <label>
                                <input type="checkbox" id="select-all-permissions"> Select all
                            </label>
                            <br/>
                            <!-- Permission Checkboxes -->
                            @foreach($permissions as $permission)
                                <label>
                                    <input type="checkbox" class="permission-checkbox" name="permissions[{{ $permission->name }}]" 
                                        value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name)
                                        ? 'checked' : ''}} > {{ $permission->name }}
                                </label><br/>
                            @endforeach
                        </div>

                       

                        <div class="mt-4">
                            <button class="btn btn-success w-100 w-md-auto">Create</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- JavaScript to handle select all -->
 <script>
    document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('select-all-permissions');
    const checkboxes = document.querySelectorAll('.permission-checkbox');

    selectAll.addEventListener('change', function () {
    checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
    });
    });
    });
    </script>
@endsection
