@extends('layouts.admin')
@section('content')
    <div class=" p-3">
        <div class=" col-lg-12 p-0">
            <form id="validate-form" class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                action="{{ route('admin.clinic.appointments.store') }}">
                @csrf
                <x-bread-crumb :breads="[
                    ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
                    ['url' => route('admin.clinic.appointments.index'), 'title' => __('Appointments'), 'isactive' => false],
                    ['url' => '#', 'title' => __('Add'), 'isactive' => true],
                ]">
                </x-bread-crumb>
                <div class=" col-lg-12 p-0 m-1 main-box row">
                    <div class="row p-3">
                        <div class="col-lg-9">
                            <span class="fas fa-info-circle"></span> {{ __('Add') . ' ' . __('Appointment') }}
                        </div>
                        <div class="col-lg-3 d-flex justify-content-end align-items-start">             
                            <button class="btn btn-primary" id="submitEvaluation">
                                <i class="fal fa-save"></i> 
                                {{ __('Save')}}
                            </button>
                        </div>
                    </div>
                    <div class=" divider" style="min-height: 2px;"></div>
                    <div class="row pb-3">
                        <div class="col-lg-8">
                            <div class="row pt-2 mt-2">
                                <div class=" col-lg-12 p-2  mb-2">
                                    <div class="">
                                        {{ __('Date of visit') }}
                                    </div>
                                    <div class="pt-1 position-relative">
                                        <input type="date" value="{{ old('dov' , now()->toDateString('Y-m-d')) }}" name="dov"  min="{{ now()->toDateString('Y-m-d') }}" class="form-control @error('dov') is-invalid @enderror" >
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('dov') ?: __('validation.required' , ['attribute' => __('Date of visit')]) }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class=" col-lg-12 p-2  mb-2">
                                    <div class="">
                                        {{ __('Visit type') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4 @error('type') is-invalid @enderror"  name="type">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option @if (old('type') == 'check') selected @endif value="check">
                                                {{ __('Check') }}</option>
                                            <option @if (old('type') == 'follow_up') selected @endif value="follow_up">
                                                {{ __('Follow up') }}</option>
                                        </select>
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('type') ?: __('validation.required' , ['attribute' =>  __('Visit type') ]) }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=" col-lg-4"> 
                           <patient-form
                           :patient-old-data='@json(old())' 
                           :errors='@json($errors->getMessages())'></patient-form>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script type="module">
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
@endsection
