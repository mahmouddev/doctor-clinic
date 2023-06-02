@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.taxes.store') }}">
                @csrf
                <x-bread-crumb :breads="[
                    ['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
                    ['url' => route('admin.taxes.index') , 'title' => __('Taxes') , 'isactive' => false],
                    ['url' => '#' , 'title' =>  __('Add') , 'isactive' => true],
                    ]">
                </x-bread-crumb>
                <div class="col-12 col-lg-12 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> {{ __('Add') }}
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <div class="col-12 p-12 row">

                        <div class="col-12 col-lg-12 p-2">
                            <div class="col-12">
                                {{ __('Name')}}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="name" required maxlength="190" class="form-control"
                                    value="{{ old('name', $tax ?? '') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-12 p-2">
                            <div class="col-12">
                                 {{ __('Percentage')}}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="number" step="0.1" min="0" max="100" name="percentage" required maxlength="190" class="form-control"
                                    value="{{ old('percentage', $tax ?? '') }}">
                            </div>
                        </div>
                        

                        <div class="col-12 p-2 d-flex justify-content-end align-items-start">
                            <button class="btn btn-success" id="submitEvaluation">{{ __('Save') }}</button>
                        </div>
                    </div>


                </div>

            </form>
        </div>
    </div>
@endsection
