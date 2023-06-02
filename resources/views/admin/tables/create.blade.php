@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.tables.store') }}">
                @csrf
                <x-bread-crumb :breads="[
                    ['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
                    ['url' => route('admin.tables.index') , 'title' => __('Tables') , 'isactive' => false],
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
                                {{__('Tables')}}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="number" required maxlength="190" class="form-control"
                                    value="{{ old('number', $table ?? '') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-12 p-2">
                            <div class="col-12">
                                {{ __('Branch')}}
                            </div>
                            <div class="col-12 pt-3">
                                <select  name="branch_id" required maxlength="190" class="form-control">
                                    <option> {{ __('Select branch')}}</option>
                                    @foreach ($branches as $branch)
                                        <option value='{{ $branch->id}}'>{{ $branch->name}}</option>
                                    @endforeach
                                </select>
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
