@extends('layouts.admin')
@section('content')
<div class="p-3">
	<!-- breadcrumb -->
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
			['url' => route('admin.clinic.invoices.index') , 'title' => __('Invoices') , 'isactive' => true],
		]">
		</x-bread-crumb>
	<!-- /breadcrumb -->
	<div class="col-lg-12 p-0 main-box">
		<div class="row p-3">
			<div class="col-lg-9">
				<span class="fas fa-file-invoice"></span>	{{ __('Invoices') }}
			</div>
			<div class="col-lg-3 d-flex justify-content-end align-items-start">             
				@can('invoices-create')
				{{-- <a href="{{route('admin.clinic.invoices.create')}}">
					<span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('Add') }}</span>
				</a> --}}
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
									<th>{{__('Patient')}}</th>
									<th>{{__('Phone')}}</th>
									<th>{{__('Payout')}}</th>
									<th>{{__('Date')}}</th>
									<th>{{__('Actions')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($invoices as $invoice)
								<tr>
									<td>{{$invoice->id}}</td>
									<td>{{@$invoice->appointment->patient->name}}</td>
									<td>{{@$invoice->appointment->patient->phone}}</td>
									<td>{{$invoice->total_price}}</td>
									<td>{{$invoice->created_at->toDateString()}}</td>
									<td>
										@can('invoices-update')
										<a href="{{route('admin.clinic.invoices.view',$invoice)}}">
										<span class="btn  btn-outline-success btn-sm font-1 mx-1">
											<span class="fas fa-eye "></span> {{ __('View') }}
										</span>
										</a>
										@endcan
										@can('invoices-delete')
										<form method="POST" action="{{route('admin.clinic.invoices.destroy',$invoice)}}" class="d-inline-block">@csrf @method("DELETE")
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
				{{$invoices->appends(request()->query())->render()}}
			</div>
		</div>
	</div>
</div>
@endsection
