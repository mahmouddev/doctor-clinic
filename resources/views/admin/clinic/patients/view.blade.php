@extends('layouts.admin')

@section('styles')
    <style>
    </style>
@endsection
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <x-bread-crumb :breads="[
                ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
                ['url' => route('admin.clinic.patients.index'), 'title' => __('Patients'), 'isactive' => false],
                ['url' => '#', 'title' => __('View'), 'isactive' => true],
            ]">
            </x-bread-crumb>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="/img/svg/{{$patient->gendar}}_avatar.svg"
                                alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3 text-center">{{ $patient->name }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{_('Email')}}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $patient->email }}</p>
                                </div>
                            </div>
                            <hr>
                            
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('Phone')}}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $patient->phone }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('Date of birth') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $patient->dob->format('Y-m-d')}}</p>
                                </div>
                            </div>
                             <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">{{ __('Blood group') }}</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{ $patient->blood_group }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 p-3 row">
        <!-- Appointments -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                {{ __('Appointments') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $patient->appointments?->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total bills -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                {{ __('Total bills') }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ${{ $patient->invoices?->sum('total_price') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{ __('Invoices') }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $patient->invoices?->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 p-3 row">
        <div class="main-box pt-3">
            <ul class="nav nav-tabs no-padding" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="appointments-tab" data-bs-toggle="tab"
                        data-bs-target="#appointments" type="button" role="tab" aria-controls="appointments"
                        aria-selected="true">{{ __('Appointments') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices"
                        type="button" role="tab" aria-controls="invoices"
                        aria-selected="false">{{ __('Invoices') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="prescription-tab" data-bs-toggle="tab" data-bs-target="#prescription"
                        type="button" role="tab" aria-controls="prescription"
                        aria-selected="false">{{ __('Prescription') }}</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="appointments" role="tabpanel"
                    aria-labelledby="appointments-tab">
                    <div class="col-lg-12" style="overflow:auto">
                        <div class="row pt-2">
                            <div class="col-lg-12 p-2">
                                <table class="table table-bordered  table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Visit type') }}</th>
                                            <th>{{ __('Date of visit') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patient->appointments as $appointment)
                                            <tr>
                                                <td>{{ $appointment->id }}</td>
                                                <td>{{ @$appointment->patient->name }}</td>
                                                <td>{{ @$appointment->patient->phone }}</td>
                                                <td>{{ $appointment->type }}</td>
                                                <td>{{ $appointment->dov->toDateString() }}</td>
                                                <td>
                                                    @can('appointments-update')
                                                        @if (!$appointment->invoice)
                                                            <pay-order-btn action="{{ route('admin.clinic.invoices.store') }}"
                                                                csrf="{{ csrf_token() }}" icon="fas fa-credit-card"
                                                                appointment="{{ $appointment->id }}"
                                                                patient="{{ $appointment->patient_id }}"></pay-order-btn>
                                                        @endif
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
                <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab">
                    <div class="col-lg-12" style="overflow:auto">
                        <div class="row pt-2">
                            <div class="col-lg-12 p-2">
                                <table class="table table-bordered  table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Patient') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Payout') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patient->invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->id }}</td>
                                                <td>{{ @$invoice->appointment->patient->name }}</td>
                                                <td>{{ @$invoice->appointment->patient->phone }}</td>
                                                <td>{{ $invoice->total_price }}</td>
                                                <td>{{ $invoice->created_at->toDateString() }}</td>
                                                <td>
                                                    @can('invoices-update')
                                                        <a target="_blank"
                                                            href="{{ route('admin.clinic.invoices.view', $invoice) }}">
                                                            <span class="btn  btn-outline-success btn-sm font-1 mx-1">
                                                                <span class="fas fa-eye "></span> {{ __('View') }}
                                                            </span>
                                                        </a>
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
                <div class="tab-pane fade" id="prescription" role="tabpanel" aria-labelledby="prescription-tab">
                    <div class="col-lg-12" style="overflow:auto">
                        <div class="row pt-2">
                            <div class="col-lg-12 p-2">
                                <table class="table table-bordered  table-hover table-responsive">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Date of visit') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patient->prescriptions as $prescription)
                                            <tr>
                                                <td>{{ $prescription->id }}</td>
                                                <td>{{ @$prescription->patient->name }}</td>
                                                <td>{{ @$prescription->patient->phone }}</td>
                                                <td>{{ $prescription->appointment ? $prescription->appointment->dov->toDateString() : '' }}
                                                </td>
                                                <td>
                                                    @can('prescriptions-read')
                                                        <a target="_blank"
                                                            href="{{ route('admin.clinic.prescriptions.view', $prescription) }}">
                                                            <span class="btn  btn-outline-success btn-sm font-1 mx-1">
                                                                <span class="fas fa-eye "></span> {{ __('View') }}
                                                            </span>
                                                        </a>
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
    </div>
@endsection
