@extends('layouts.master')
@section('content')
    @include('layouts.partials.header')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{__('Roles')}}</h6>
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-icon-split fr">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">{{__('Create')}}</span>
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Role Name') }}</th>
                            <th>{{ __('Actions') }}</th>

                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a href="#" data-id="{{ $role->id }}"
                                        class="btn btn-danger btn-circle fr delete-confirm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </a>

                                    <a href="{{ route('roles.edit', ['role' => $role]) }}"
                                        class="btn btn-info btn-circle fr">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>

                                    </a>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@include('layouts.partials.scripts')

<script>
    $(document).ready(function() {
        $('.delete-confirm').click(function() {
            var id = $(this).data('id');
            var route = "{{ route('roles.destroy', ['role' => ':id']) }}";
            route = route.replace(':id', id);
            showDeleteConfirmation(id, route);
        });
    });
</script>
