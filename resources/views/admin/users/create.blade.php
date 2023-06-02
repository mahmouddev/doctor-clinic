@extends('layouts.admin')
@section('content')
<div class="col-12 p-3">
	<div class="col-12 col-lg-12 p-0">
		<form id="validate-form" class="row" enctype="multipart/form-data" method="POST" action="{{route('admin.users.store')}}">
			@csrf
			<x-bread-crumb :breads="[
				['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
			    ['url' => route('admin.users.index') , 'title' => __('Users') , 'isactive' => false],
				['url' => '#' , 'title' =>  __('Add'), 'isactive' => true],
			]">
			</x-bread-crumb>
			<div class="col-12 col-lg-12 p-0 m-1 main-box row">
				<div class="col-12 px-0 row">
					<div class="col-8 px-3 py-3">
						<span class="fas fa-info-circle"></span>	{{ __('Add').' '.__('User') }}
					</div>
					<div class="col-4 p-2 d-flex justify-content-end align-items-start">
						<button class="btn btn-primary" id="submitEvaluation"><i class="fal fa-save"></i></button>
					</div>
					<div class="col-12 divider" style="min-height: 2px;"></div>
				</div>
				<div class="col-8 col-lg-8 row">
					
					<div class="col-12 col-lg-12 p-2">
						<div class="col-12">
							{{ __('Name')}}
						</div>
						<div class="col-12 pt-3">
							<input type="text" name="name" required minlength="3"  maxlength="190" class="form-control" value="{{old('name')}}" >
						</div>
					</div>
				
					<div class="col-6 col-lg-6 p-2">
						<div class="col-12">
							{{ __('Email')}}
						</div>
						<div class="col-12 pt-3">
							<input type="email" name="email"  class="form-control"  value="{{old('email')}}" >
						</div>
					</div>
					
					<div class="col-6 col-lg-6 p-2">
						<div class="col-12">
							{{ __('Password')}}
						</div>
						<div class="col-12 pt-3">
							<input type="password" name="password"  class="form-control" required minlength="8" >
						</div>
					</div>
					
					<div class="col-12 col-lg-12 p-2">
						<div class="col-12">
							{{ __('Bio')}}
						</div>
						<div class="col-12 pt-3">
							<textarea  name="bio" maxlength="5000" class="form-control" style="min-height:150px">{{old('bio')}}</textarea>
						</div>
					</div>
				</div>
				<div class="col-4 col-lg-4">

					<div class="col-12 col-lg-12 p-2">
						<div class="col-12">
							{{ __('Role')}}
						</div>
						<div class="col-12  pt-3">
							<select class="form-control select2-select selectize" name="roles[]" multiple required>
								@foreach($roles as $role)
									<option value="{{$role->id}}">{{$role->name}}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-12 col-lg-12 p-2">
						<div class="col-12">
							{{ __('Phone')}}
						</div>
						<div class="col-12 pt-3">
							<input type="text" name="phone"   maxlength="190" class="form-control"  value="{{old('phone')}}" >
						</div>
					</div>
					
					<div class="col-12 col-lg-12 p-2">
						<div class="col-12">
							{{ __('Banned')}}
						</div>
						<div class="col-12 pt-3">
							<select class="form-control" name="blocked">
								<option @if(old('blocked')=="0") selected @endif value="0">{{ __('No')}}</option>
								<option @if(old('blocked')=="1") selected @endif value="1">{{ __('Yes')}}</option>
							</select>
						</div>
					</div>
					<div class="col-12 col-lg-12 p-2">
						<div class="col-12">
							{{ __('Avatar')}}
						</div>
						<div class="col-12 pt-3">
							<input type="file" name="avatar"  class="form-control"  accept="image/*" >
						</div>
						<div class="col-12 p-0">
							
						</div>
					</div>
				</div>

			</div>

		</form>

	</div>
</div>
@endsection