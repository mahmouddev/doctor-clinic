@extends('layouts.admin')
@section('content')
    <div class=" p-3">
        <div class=" col-lg-12 p-0">
            <form id="validate-form" class="needs-validation" novalidate enctype="multipart/form-data" method="POST"
                action="{{ route('admin.clinic.prescriptions.store') }}">
                @csrf
                <x-bread-crumb :breads="[
                    ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
                    ['url' => route('admin.clinic.prescriptions.index'), 'title' => __('Prescriptions'), 'isactive' => false],
                    ['url' => '#', 'title' => __('Add'), 'isactive' => true],
                ]">
                </x-bread-crumb>
                <div class=" col-lg-12 p-0 m-1 main-box row">
                    <div class="row p-3">
                        <div class="col-lg-9">
                            <span class="fas fa-info-circle"></span> {{ __('Add') . ' ' . __('Prescription') }}
                        </div>
                        <div class="col-lg-3 d-flex justify-content-end align-items-start">             
                            <button class="btn btn-primary" id="submitEvaluation">
                                <i class="fal fa-save"></i> 
                                {{ __('Save')}}
                            </button>
                        </div>
                    </div>
                    <div class=" divider" style="min-height: 2px;"></div>
                    
                        <patient-prescription-form
                        :patient-old-data='@json(old())' 
                        :errors='@json($errors->getMessages())'></patient-prescription-form>
                    
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
