@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                action="{{ route('admin.items.update', $item) }}">
                @csrf
                @method('PUT')
                <x-bread-crumb :breads="[
				['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
				['url' => route('admin.items.index') , 'title' => __('Menu items') , 'isactive' => false],
				['url' => '#' , 'title' =>  __('Edit') , 'isactive' => true],
                ]">
                </x-bread-crumb>
                <div class="col-12 col-lg-12 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span>  {{ __('Edit') }}  ({{ old('name', $item ?? '') }})
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
                                    value="{{ old('name', $item ?? '') }}">
                            </div>
                        </div>

                        <div class="col-12 col-lg-12 p-2">
                            <div class="col-12">
                                {{ __('Category')}}
                            </div>
                            <div class="col-12 pt-3">
                                <select  name="category_id" required maxlength="190" class="form-control">
                                    <option>{{ __('Select category')}}</option>
                                    @foreach ($categories as $category)
                                        <option {{ $category->id == $item->category_id ? " selected" : null }} value='{{ $category->id}}'>{{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6 p-2">
                        <div class="col-12">
                            {{ __('Image')}}
                        </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="image" class="form-control" accept="image/*" style="margin-top:0.2rem">
                            </div>
                            <div class="col-12 pt-3">
                                <img src="{{$item->getImage()}}" style="width:120px;">
                            </div>
                        </div>

                        <div class="col-6 col-lg-6 p-2">
                            <div class="col-12">
                                {{ __('Price')}}
                            </div>
                            <div class="col-12 pt-3">
                                <input type="text" name="price" required maxlength="190" class="form-control"
                                    value="{{ old('price', $item ?? '') }}">
                            </div>
                        </div>

                        <div class="col-12  col-lg-12 p-2">
                            <div class="col-12">
                                {{ __('Description')}} 
                            </div>
                            <div class="col-12 pt-3">
                                <textarea name="description" class="editor">{{old('description', $item ?? '')}}</textarea>
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
