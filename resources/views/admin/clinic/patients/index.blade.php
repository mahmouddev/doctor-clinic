@extends('layouts.admin')
@section('content')
<div class="p-3">
	<!-- breadcrumb -->
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
			['url' => route('admin.clinic.patients.index') , 'title' => __('Patients') , 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->
	<div class="col-lg-12 p-0 main-box">
		<div class="row p-3">
			<div class="col-lg-9">
				<span class="fas fa-users"></span>	{{ __('Patients') }}
			</div>
			<div class="col-lg-3 d-flex justify-content-end align-items-start">             
				@can('patients-create')
				<a href="{{route('admin.clinic.patients.create')}}">
					<span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('Add') }}</span>
				</a>
				@endcan
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="row pt-2">
					<div class="col-lg-4 p-2">
						<form method="GET" class="accept-submit">
							<input type="text" name="q" class="form-control" placeholder="{{ __('Search') }} " value="{{request()->get('q')}}">
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-12" style="overflow:auto">
				<div class="row pt-2">
					<div class="col-lg-12 p-2">
						<table class="table table-bordered  table-hover table-responsive">
							<thead>
								<tr>
									<th>#</th>
									<th>{{__('Name')}}</th>
									<th>{{__('Phone')}}</th>
									<th>{{__('Email')}}</th>
									<th>{{__('Actions')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($patients as $patient)
								<tr>
									<td>{{$patient->id}}</td>
									<td>{{$patient->name}}</td>
									<td>{{$patient->phone}}</td>
									<td>{{$patient->email}}</td>
									<td>
										@can('patients-view')
										<a href="{{route('admin.clinic.patients.show',$patient)}}">
										<span class="btn  btn-outline-success btn-sm font-1 mx-1">
											<span class="fas fa-eye "></span> {{ __('View') }}
										</span>
										</a>
										@endcan
										@can('patients-update')
										<a href="{{route('admin.clinic.patients.edit',$patient)}}">
										<span class="btn  btn-outline-success btn-sm font-1 mx-1">
											<span class="fas fa-wrench "></span> {{ __('Edit') }}
										</span>
										</a>
										@endcan
										@can('patients-delete')
										<form method="POST" action="{{route('admin.clinic.patients.destroy',$patient)}}" class="d-inline-block">@csrf @method("DELETE")
											<button class="btn  btn-outline-danger btn-sm font-1 mx-1" onclick="var result = confirm('{{ __('Are sure of the deleting process ?')}}');if(result){}else{event.preventDefault()}">
												<span class="fas fa-trash "></span> {{ __('Delete')}}
											</button>
										</form>
										@endcan
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-lg-12 p-3">
				{{$patients->appends(request()->query())->render()}}
			</div>
		</div>
	</div>
</div>
@endsection
