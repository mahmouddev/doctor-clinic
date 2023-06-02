@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
	<x-bread-crumb :breads="[
			['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
			['url' => route('admin.tables.index') , 'title' => __('Tables') , 'isactive' => true],
		]">
	</x-bread-crumb>
	<div class="col-12 col-lg-12 p-0 main-box">
	 
		<div class="col-12 px-0">
			<div class="col-12 p-0 row">
				<div class="col-12 col-lg-4 py-3 px-3">
					<span class="fas fa-table"></span> {{ __('Tables') }}
				</div>
				<div class="col-12 col-lg-4 p-0">
				</div>
				<div class="col-12 col-lg-4 p-2 text-lg-end">
					 @can('tables-create') 
					<a href="{{route('admin.tables.create')}}">
					<span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('Add') }}</span>
					</a>
					 @endcan 
				</div>
			</div>
			<div class="col-12 divider" style="min-height: 2px;"></div>
		</div>

		<div class="col-12 py-2 px-2 row">
			<div class="col-12 col-lg-4 p-2">
				<form method="GET" class="accept-submit">
					<input type="text" name="q" class="form-control" placeholder="{{ __('Search') }} " value="{{request()->get('q')}}">
				</form>
			</div>
		</div>
		<div class="col-12 p-3" style="overflow:auto">
			<div class="col-12 p-0">
				
			
			<table class="table table-bordered  table-hover table-responsive">
				<thead>
					<tr>
						<th>#</th>
						<th>{{ __('Table Number')}}</th>
						<th>{{ __('Actions') }}</th>
					</tr>
				</thead>
				<tbody id="sortable-table">
					@foreach($tables as $table)
					<tr >
						<td class="ui-state-default drag-handler" data-table="{{$table->id}}">{{$table->id}}</td>
						<td>{{$table->number}}</td>
					 
						<td style="width: 270px;">

					 
							 @can('tables-update') 
							<a href="{{route('admin.tables.edit',$table)}}">
								<span class="btn  btn-outline-success btn-sm font-1 mx-1">
									<span class="fas fa-wrench "></span> {{ __('Edit') }}
								</span>
							</a>
							 @endcan 
							 @can('tables-delete') 
							<form method="POST" action="{{route('admin.tables.destroy',$table)}}" class="d-inline-block">@csrf @method("DELETE")
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
		<div class="col-12 p-3">
			{{$tables->appends(request()->query())->render()}}
		</div>
	</div>
</div>
@endsection