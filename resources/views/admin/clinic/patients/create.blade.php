@extends('layouts.admin')
@section('content')
    <div class=" p-3">
        <div class=" col-lg-12 p-0">
            <form id="validate-form" class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                action="{{ route('admin.clinic.patients.store') }}">
                @csrf
                <x-bread-crumb :breads="[
                    ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
                    ['url' => route('admin.clinic.patients.index'), 'title' => __('Patients'), 'isactive' => false],
                    ['url' => '#', 'title' => __('Add'), 'isactive' => true],
                ]">
                </x-bread-crumb>
                <div class=" col-lg-12 p-0 m-1 main-box row">
                    <div class="row p-3">
                        <div class="col-lg-9">
                            <span class="fas fa-info-circle"></span> {{ __('Add') . ' ' . __('Patient') }}
                        </div>
                        <div class="col-lg-3 d-flex justify-content-end align-items-start">             
                            <button class="btn btn-primary" id="submitEvaluation">
                                <i class="fal fa-save"></i> 
                                {{ __('Save')}}
                            </button>
                        </div>
                    </div>
                    <div class=" divider" style="min-height: 2px;"></div>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row pt-2">
                                <div class="col-lg-12 p-2">
                                    <div class="">
                                        {{ __('Name') }}
                                    </div>
                                    <div class="pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" name="name" required minlength="3" maxlength="190"
                                            class="form-control px-4 @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('name') ?: __('validation.required' , ['attribute' => __('Name')]) }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-2 mt-2">
                                <div class=" col-lg-4 p-2">
                                    <div class="">
                                        {{ __('Email') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control px-4 @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}">
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('email') ?: __('validation.required' , ['attribute' => __('Email')]) }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class=" col-lg-4 p-2">
                                    <div class="">
                                        {{ __('Phone') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fa fa-mobile-alt"></i>
                                        </span>
                                        <input type="phone" value="{{ old('phone') }}" name="phone" required class="form-control px-4 @error('phone') is-invalid @enderror" >
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('phone') ?: __('validation.required' , ['attribute' => __('Phone')]) }}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class=" col-lg-4 p-2">
                                    <div class="">
                                        {{ __('Date of birth') }}
                                    </div>
                                    <div class="pt-1 position-relative">
                                        <input type="date" value="{{ old('dob') }}" name="dob" required class="form-control @error('dob') is-invalid @enderror" >
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('dob') ?: __('validation.required' , ['attribute' => __('Date of birth')]) }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-2 mt-2">
                                <div class=" col-lg-4 p-2">
                                    <div class="">
                                        {{ __('Gendar') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4 @error('gendar') is-invalid @enderror" required name="gendar">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option @if (old('gendar') == 'male') selected @endif value="male">
                                                {{ __('Male') }}</option>
                                            <option @if (old('gendar') == 'female') selected @endif value="female">
                                                {{ __('Female') }}</option>
                                        </select>
                                        <span class="invalid-feedback position-absolute">
                                            <strong>{{ $errors->first('gendar') ?: __('validation.required' , ['attribute' => __('Gendar')]) }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class=" col-lg-4 p-2">
                                    <div class="">
                                        {{ __('Blood group') }}
                                    </div>
                                    @php
                                        $blood_groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-', 'Unknown'];
                                    @endphp
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4" name="blood_group">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            @foreach ($blood_groups as $blood_group)
                                                <option @if (old('blood_group') == $blood_group) selected @endif
                                                    value="{{ $blood_group }}">{{ __($blood_group) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-lg-4 p-2">
                                    <div class="">
                                        {{ __('Diabetic') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4" name="diabetic">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option class="pt-1" @if (old('diabetic') == '0') selected @endif value="0">{{ __('No') }}</option>
                                            <option class="pt-1" @if (old('diabetic') == '1') selected @endif value="1">{{ __('Yes')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-2 mt-2">
                                <div class=" col-lg-12 p-2">
                                    <div class="">
                                        {{ __('Comments') }}
                                    </div>
                                    <div class=" pt-3">
                                        <textarea name="comments" maxlength="5000" class="form-control" style="min-height:150px">{{ old('comments') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-3">
                            <div class="row pt-2">
                                <div class=" col-lg-12 p-2">
                                    <div class="">
                                        {{ __('High Blood Pressure') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4" name="hbp">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option @if (old('hbp') == '0') selected @endif value="0">
                                                {{ __('No') }}</option>
                                            <option @if (old('hbp') == '1') selected @endif value="1">
                                                {{ __('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class=" col-lg-12 p-2">
                                    <div class="">
                                        {{ __('Heart Diseases') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4" name="heart_diseases">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option @if (old('heart_diseases') == '0') selected @endif value="0">
                                                {{ __('No') }}</option>
                                            <option @if (old('heart_diseases') == '1') selected @endif value="1">
                                                {{ __('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class=" col-lg-12 p-2">
                                    <div class="">
                                        {{ __('Accidents') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4" name="accidents">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option @if (old('accidents') == '0') selected @endif value="0">
                                                {{ __('No') }}</option>
                                            <option @if (old('accidents') == '1') selected @endif value="1">
                                                {{ __('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class=" col-lg-12 p-2">
                                    <div class="">
                                        {{ __('Surgeries') }}
                                    </div>
                                    <div class=" pt-1 position-relative">
                                        <span class="position-absolute top-30 px-2">
                                            <i class="fas fa-file-medical-alt"></i>
                                        </span>
                                        <select class="form-control px-4" name="surgeries">
                                            <option value="">{{__('Plese select.....')}}</option>
                                            <option @if (old('surgeries') == '0') selected @endif value="0">
                                                {{ __('No') }}</option>
                                            <option @if (old('surgeries') == '1') selected @endif value="1">
                                                {{ __('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
