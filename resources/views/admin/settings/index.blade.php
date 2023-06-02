@extends('layouts.admin')

@section('styles')
    <style type="text/css">
        .settings-tab-opener {
            /*box-shadow: 0px 6px 12px #ebebeb;*/
            border-radius: 0px;
            cursor: pointer;
            width: 80px;
            height: 45px;
            border-left: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .settings-tab-opener.active {
            box-shadow: 0px 6px 12px #c8e0ff;
            color: #fff;
            background: #2196f3;
        }

        .taber:not(.active) {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="col-12 p-3 row">
        <div class="col-12 p-2 p-lg-4 main-box" style="min-height: 80vh;border-radius:10px">
            <div class="col-12 px-3 pb-3 pt-2">
                <h4 class="font-4">{{  __('Settings')}}</h4>
            </div>
        
            <form class="col-12 row " id="validate-form" method="POST" action="{{ route('admin.settings.update') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-12 col-lg-12 px-3 py-5">
                    <div class="col-12 row p-0">
                        <div class="col-12 px-0 d-flex mb-3 row pb-3">
                            <div class="col-12 col-lg-3 px-2 pt-1 pb-3">
                                {{ __('Dark night mode')}}
                            </div>
                            <div class="col-12 col-lg-9 px-2 pt-1 pb-3">
                                <div class="form-check form-switch text-lg-end">
                                    <input type="hidden" name="settings[dashboard_dark_mode]" value="0">
                                    <input class="form-check-input" type="checkbox" id="DarkModeInput"
                                        name="settings[dashboard_dark_mode]"
                                        {{ $settings['dashboard_dark_mode'] == 1 ? 'checked' : '' }} value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 row p-0">
                        <div class="col-12 px-0 d-flex mb-3 row pb-3">
                            <div class="col-12 col-lg-3 px-2 text-lg-end pt-1 pb-3 pb-lg-0">
                            </div>
                            <div class="col-12 col-lg-9 px-2 text-lg-end">
                                <button class="btn  btn-warning pb-2 px-4" >{{ __('Save') }}</button>
                            </div>
                        </div>

                    </div>
            </form>
        </div>
    </div>
@endsection
