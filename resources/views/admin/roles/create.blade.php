@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
    <div class="col-12 col-lg-12 p-0">
        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
            action="{{ route('admin.roles.store') }}">
            @csrf
            <!-- breadcrumb -->
            <x-bread-crumb :breads="[
                ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
                ['url' => route('admin.roles.index'), 'title' => __('Roles & Permessions'), 'isactive' => false],
                ['url' => '#', 'title' => __('Add'), 'isactive' => true],
            ]">
            </x-bread-crumb>
            <!-- /breadcrumb -->
            <div class="col-12 col-lg-12 p-0 m-1 main-box row">
                <div class="col-12 px-0 row">
					<div class="col-8 px-3 py-3">
						<span class="fas fa-info-circle"></span>  {{ __('Add') .' '.__('Role & Permession') }}
					</div>
					<div class="col-4 p-2 d-flex justify-content-end align-items-start">
						<button class="btn btn-primary" id="submitEvaluation"><i class="fal fa-save"></i></button>
					</div>
					<div class="col-12 divider" style="min-height: 2px;"></div>
				</div>
                <div class="col-6 col-lg-6">
                    <div class="col-12 col-lg-12 p-2">
                        <div class="col-12">
                            {{ __('Name') }}
                        </div>
                        <div class="col-12 pt-3">
                            <input type="text" name="name" required maxlength="190" class="form-control"
                                value="{{ old('name', $role ?? '') }}">
                        </div>
                    </div>
                    <div class="col-12 p-2">
                        <div class="col-12">
                            {{ __('Description') }}
                        </div>
                        <div class="col-12 pt-3">
                            <textarea name="description" class="form-control" style="min-height:150px">{{ old('description', $role ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-6">
                    <table class="table table-hover">
                        <thead>
                            <tr style="">
                                <th></th>
                                <th style="width: 56px;">{{ __('Add') }}</th>
                                <th style="width: 56px;">{{ __('show') }}</th>
                                <th style="width: 56px;">{{ __('Edit') }}</th>
                                <th style="width: 56px;">{{ __('Delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $permissions = \Spatie\Permission\Models\Permission::groupBy('table')->get();
                            @endphp
                            @foreach ($permissions as $permission)
                                @php
                                    $sub_permissions = \Spatie\Permission\Models\Permission::where('table', $permission->table)->get();
                                @endphp
                                <tr>



                                    <td>{{ $permission->table }}</td>

                                    @if ($sub_permissions->where('name', $permission->table . '-create')->first())
                                        <td style="width: 56px;">

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="{{ $permission->table . '-create' }}"
                                                    value="{{ $permission->table . '-create' }}"
                                                    @if (isset($role) && $role->hasPermissionTo($permission->table . '-create')) checked @endif name="permissions[]">
                                            </div>
                                        </td>
                                    @else
                                        <td style="width: 56px;">
                                        </td>
                                    @endif
                                    @if ($sub_permissions->where('name', $permission->table . '-read')->first())
                                        <td style="width: 56px;">

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="{{ $permission->table . '-read' }}"
                                                    value="{{ $permission->table . '-read' }}"
                                                    @if (isset($role) && $role->hasPermissionTo($permission->table . '-read')) checked @endif name="permissions[]">
                                            </div>
                                        </td>
                                    @else
                                        <td style="width: 56px;">
                                        </td>
                                    @endif
                                    @if ($sub_permissions->where('name', $permission->table . '-update')->first())
                                        <td style="width: 56px;">

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="{{ $permission->table . '-update' }}"
                                                    value="{{ $permission->table . '-update' }}"
                                                    @if (isset($role) && $role->hasPermissionTo($permission->table . '-update')) checked @endif name="permissions[]">
                                            </div>
                                        </td>
                                    @else
                                        <td style="width: 56px;">
                                        </td>
                                    @endif
                                    @if ($sub_permissions->where('name', $permission->table . '-delete')->first())
                                        <td style="width: 56px;">

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="{{ $permission->table . '-delete' }}"
                                                    value="{{ $permission->table . '-delete' }}"
                                                    @if (isset($role) && $role->hasPermissionTo($permission->table . '-delete')) checked @endif name="permissions[]">
                                            </div>
                                        </td>
                                    @else
                                        <td style="width: 56px;">
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>



                </div>
            </div>
        </form>
    </div>
</div>
@endsection
