@extends('layouts.admin')
@section('content')
<div class="p-3">
	<!-- breadcrumb -->
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
			['url' => route('admin.clinic.appointments.today-appointments') , 'title' => __('Today Appointments') , 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->
 	
	<div class="col-12 pt-3 main-box">
		<div class="row p-3">
			<div class="col-lg-9">
				<span class="fas fa-calendar-check"></span>	{{ __('Today Appointments') }}
			</div>
			<div class="col-lg-3 d-flex justify-content-end align-items-start">            
				@can('appointments-create')
				<a clss="m-3" href="{{route('admin.clinic.appointments.create')}}">
					<span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('Add') }}</span>
				</a>
				@endcan
			</div>
		</div>
		<div class="row">
		
			<div class="col-lg-12" style="overflow:auto">
				<div class="row pt-2">
					<div class="col-lg-12 p-2">
						<table class="table table-bordered  table-hover table-responsive">
							<thead>
								<tr>
									<th>#</th>
									<th>{{__('Name')}}</th>
									<th>{{__('Phone')}}</th>
									<th>{{__('Visit type')}}</th>
									<th>{{__('Date of visit')}}</th>
									<th>{{__('Actions')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($todayAppointments as $appointment)
								<tr>
									<td>{{$appointment->id}}</td>
									<td>{{@$appointment->patient->name}}</td>
									<td>{{@$appointment->patient->phone}}</td>
									<td>{{$appointment->type}}</td>
									<td>{{$appointment->dov->toDateString()}}</td>
									<td>
										@can('appointments-update')
										@if(!$appointment->invoice)
										<pay-order-btn
												action="{{ route('admin.clinic.invoices.store') }}"
												csrf="{{ csrf_token() }}"
												icon="fas fa-credit-card"
												appointment="{{$appointment->id}}"
												patient="{{$appointment->patient_id}}"
												></pay-order-btn>
										@endif

										{{-- @if(!$appointment->prescription)
										<edit-prescription-btn
												action="{{ route('admin.clinic.prescriptions.store') }}"
												csrf="{{ csrf_token() }}"
												icon="fas fa-file-prescription"
												appointment="{{$appointment->id}}"
												></edit-prescription-btn>
										@endif --}}
										@endcan
										
										@can('appointments-delete')
										<form method="POST" action="{{route('admin.clinic.appointments.destroy',$appointment)}}" class="d-inline-block">
											@csrf 
											@method("DELETE")
											<input type="hidden" name="redirect" value="{{ route('admin.clinic.appointments.today-appointments')}}">
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
		
		</div>
	</div>

</div>
@endsection
