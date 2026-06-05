@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Role details') }}</div>

                <div class="card-body">
                    <a href="{{ route('roles.index') }}" class="btn btn-info mb-3">Return</a>

                    <div class="mb-3">
                        <div class="mb-2">
                            <strong>name of Role :</strong>
                            <span>{{ $role->name }}</span>
                        </div>

                        <div class="mb-2">
                            <strong>Associated Permission :</strong>
                            @if($role->permissions->count())
                                <ul class="list-group mt-2">
                                    @foreach ($role->permissions as $permission)
                                        <li class="list-group-item">{{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mt-2">this Role has no assigned permission.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
