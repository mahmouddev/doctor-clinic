@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
	<div class="col-12 col-lg-12 p-0 ">
		    <x-bread-crumb :breads="[
                    ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
                    ['url' => route('admin.roles.index'), 'title' => __('Roles & Permessions'), 'isactive' => false],
                    ['url' => '#', 'title' => __('Show'), 'isactive' => true],
                ]">
			</x-bread-crumb>
		<div class="col-12 col-lg-12 p-0 main-box">

			<div class="col-12 px-0">
				<div class="col-12 px-3 py-3">
				 	<span class="fas fa-info-circle"></span> {{ __('Roles & Permessions') }}
				</div>
				<div class="col-12 divider" style="min-height: 2px;"></div>
			</div>
			<div class="col-12 p-3 row">
				<table class="table table-hover" style="width:400px">
					<thead>
						<tr style="">
							<th></th>
							<th style="width: 56px;">{{ __('Add') }}</th>
							<th style="width: 56px;">{{ __('Show') }}</th>
							<th style="width: 56px;">{{ __('Edit') }}</th>
							<th style="width: 56px;">{{ __('Delete')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($permissions as $permission)
						@php
						$sub_permissions = \Spatie\Permission\Models\Permission::where('table',$permission->table)->get();
						@endphp
						<tr>
							
						 

							<td>{{$permission->table}}</td>

							@if($sub_permissions->where('name',$permission->table.'-create')->first())
							<td style="width: 56px;">

								@if($role->hasPermissionTo($permission->table.'-create')) 
									<span class="fas fa-check font-2" style="color:green;"></span>
								@endif


							</td>
							@else
							<td style="width: 56px;">
							</td>
							@endif
							@if($sub_permissions->where('name',$permission->table.'-read')->first())
							<td style="width: 56px;">
								@if($role->hasPermissionTo($permission->table.'-read')) 
									<span class="fas fa-check font-2" style="color:green;"></span>
								@endif
							</td>
							@else
							<td style="width: 56px;">
							</td>
							@endif
							@if($sub_permissions->where('name',$permission->table.'-update')->first())
							<td style="width: 56px;">
								 
								@if($role->hasPermissionTo($permission->table.'-update')) 
									<span class="fas fa-check font-2" style="color:green;"></span>
								@endif
							</td>
							@else
							<td style="width: 56px;">
							</td>
							@endif
							@if($sub_permissions->where('name',$permission->table.'-delete')->first())
							<td style="width: 56px;">
								 
								@if($role->hasPermissionTo($permission->table.'-delete')) 
									<span class="fas fa-check font-2" style="color:green;"></span>
								@endif
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
	</div>
</div>
@endsection