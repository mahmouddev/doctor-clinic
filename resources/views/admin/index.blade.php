@extends('layouts.admin')
@section('content')

<div class="col-12 p-3 row">

	<div class="col-12 col-sm-6 col-lg-3 col-xl-3 col-xxl-2 px-2 my-2">
		<div class="col-12 px-0 py-1 d-flex main-box-wedit" >
			<div style="width: 65px;" class="p-2">
				<div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
					<span class="fal fa-users fa-2x" ></span>
				</div>
			</div>
			<div style="width: calc(100% - 80px)" class="px-2 py-2">
				<a class="font-1"  href="{{route('admin.clinic.patients.index')}}" style="color: #212529">
					{{ __('Patients')}}
					<h6 class="font-3 pt-2">{{\App\Models\Patient::count()}}</h6>
				</a>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6 col-lg-3 col-xl-3 col-xxl-2 px-2 my-2">
		<div class="col-12 px-0 py-1 d-flex main-box-wedit" >
			<div style="width: 65px;" class="p-2">
				<div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background: #0194fe;color: #fff; border-radius: 50%;width: 55px;height:55px">
					<span class="fal fa-calendar-check fa-2x" ></span>
				</div>
			</div>
			<div style="width: calc(100% - 80px)" class="px-2 py-2">
				<a class="font-1" href="" style="color: #212529">
					{{ __('Appointments')}}
					<h6 class="font-3  pt-2">{{\App\Models\Invoice::count()}}</h6>
				</a>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6 col-lg-3 col-xl-3 col-xxl-2 px-2 my-2">
		<div class="col-12 px-0 py-1 d-flex main-box-wedit" >
			<div style="width: 65px;" class="p-2">
				<div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background: #0194fe;color: #fff; border-radius: 50%;width: 55px;height:55px">
					<span class="fal fa-file-invoice fa-2x" ></span>
				</div>
			</div>
			<div style="width: calc(100% - 80px)" class="px-2 py-2">
				<a class="font-1" href="" style="color: #212529;">
					{{ __('Total revenue')}}
					<h6 class="font-3 pt-2">{{\App\Models\Invoice::sum('total_price')}}</h6>
				</a>
			</div>
		</div>
	</div>

	<div class="col-12 col-sm-6 col-lg-3 col-xl-3 col-xxl-2 px-2 my-2">
		<div class="col-12 px-0 py-1 d-flex main-box-wedit" >
			<div style="width: 65px;" class="p-2">
				<div class="col-12 px-0 text-center d-flex align-items-center justify-content-center" style="background: #0194fe;color: #fff; border-radius: 50%;width: 55px;height:55px">
					<span class="fal fa-file-prescription fa-2x" ></span>
				</div>
			</div>
			<div style="width: calc(100% - 80px)" class="px-2 py-2">
				<a class="font-1" href="{{ route('admin.clinic.prescriptions.index') }}" style="color: #212529;">
					{{__('Prescriptions')}}
					<h6 class="font-3 pt-2">{{\App\Models\Prescription::count()}}</h6>
				</a>
			</div>
		</div>
	</div>

	<div class="col-12 px-2 py-2">
		<div style="height: 4px ;background: rgb(118 169 169);border-radius: 7px;transition: width .5s ease-in-out;width: 0%;" id="home-dashboard-divider"></div>
	</div>
	<livewire:dashboard-statistics />
</div>
@endsection
