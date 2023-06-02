<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon-16x16.png">
    @vite('resources/css/dashboard.css')
    <link rel="stylesheet" href="/css/bootstrap-print.min.css" media="print" />
    <style type="text/css">
        html {
            --background-0: #eef4f5;
            --background-1: #fff;
            --background-aside: #11233b;
            --background-active-link: #141e2e;
            --background-form-control-focus: #161d26;
            --color-1: #fff;
            --color-2: #575f66;
            --border-color: #f1f1f1;
            --bs-table-hover-color: #f7f7f7 !important;
            --dir: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            --text-dir: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }
    </style>
    <title>clinic</title>
    <meta name="title" content="clinic">
    @livewireStyles
    @yield('styles')

    @if ($settings['dashboard_dark_mode'])
        <style type="text/css">
            html {

                --background-0: #131923;
                --background-1: #1c222b;
                --background-aside: #11233b;
                --background-active-link: #141e2e;
                --background-form-control-focus: #161d26;

                --color-1: #fff;
                --color-2: #f1f1f1;
                --border-color: #282b2f;
                --bs-table-hover-color: #f7f7f7 !important;
            }

            .select2-dropdown,
            .select2-container--default .select2-selection--multiple,
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: var(--background-0) !important;
            }

            td,
            th {
                border-color: var(--border-color) !important;
            }

            .aside {
                background: #171f2a !important;
            }

            .aside * {
                color: var(--color-1) !important;
            }

            .aside .item-container.active {
                background: #192230 !important;
                box-shadow: 0px 12px 17px #101d30 !important;
                border-bottom: unset !important;
            }

            .aside .item-container.active * {
                color: #38b59c !important;
            }

            .sub-item.active a.active *,
            .sub-item.active a.active {
                color: #38b59c !important;
            }

            #home-dashboard-divider {
                background: #0194fe !important;
            }

            body {
                color: var(--color-1) !important;
                background: #131923 !important;
            }

            .main-box-wedit {
                box-shadow: unset;
                border-radius: 10px 25px 10px 25px;
                background: #1c222b !important;
            }

            .main-box {
                background: #1c222b !important;
                box-shadow: unset !important;
            }

            .btn {
                color: var(--color-2) !important;
            }

            table {
                color: var(--color-2) !important;
                border-color: var(--border-color) !important;
            }

            thead th {
                border-color: var(--border-color) !important;
            }

            .table-hover>tbody>tr:hover {}

            *,
            .dropdown-item {
                color: var(--color-1);
            }

            .dropdown-menu {
                background-color: var(--background-1) !important;
            }

            .dropdown-item:focus,
            .dropdown-item:hover {
                color: var(--color-1);
                background-color: var(--background-2) !important;
            }

            *[class*='border-'] {
                border-color: var(--border-color) !important;
            }

            hr {
                background: var(--border-color);
            }

            .form-control {
                background: rgb(39 38 37 / 20%);
                border-color: #8c6934;
            }

            .form-control {
                background: var(--background-1);
                border-color: var(--border-color);
            }

            .form-control:focus {
                box-shadow: unset !important;
                border: 1px solid #ff9800 !important;
                background: #0e0d0c !important;
            }

            /*.form-control:focus {
            box-shadow: unset!important;
            border: 1px solid var(--border-color)!important;
            background: var(--background-form-control-focus)!important;
        }*/
            .form-control,
            .form-control:focus {
                color: var(--color-1);
            }

            .settings-tab-opener.active,
            .settings-tab-opener {
                box-shadow: unset !important;
            }
        </style>
    @endif
</head>

<body style="background: #eef4f5" class="dash">
    <style type="text/css">
        .submenu{ 
            list-style: none; 
            margin: 0; 
            padding: 0; 
            padding-left: 3rem; 
            padding-right: 3rem;
            font-size: 12px
        }
        #toast-container>div {
            opacity: 1;
        }

        .phpdebugbar * {
            direction: ltr !important
        }

        .indashboard {
            width: 100%;
        }

        .indashboard img {
            height: 70vh;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
    </style>
    @yield('after-body')
    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="d-none">@csrf</form>
    <div class="col-12 d-flex">
        <div style="width: 260px;background: #2c7cb2;min-height: 100vh;position: fixed;z-index: 900"
            class="aside active">
            <div class="col-12 px-0 d-flex" style="height: 55px">
                <div class="col-12 p-1" style="color: var(--background-1)">
                    <div class="col-12 p-0 row">
                        <div class="col-3 py-1 px-1">
                        </div>
                        <div class="col-9 ">
                            <span
                                style="width: 55px;height: 55px;position: absolute;left: 0px;top: 0px;align-items: center;justify-content: center;cursor: pointer;"
                                class="asideToggle d-flex d-md-none rounded-0">
                                <span class="fal fa-bars font-4 "></span>
                            </span>
                        </div>
                    </div>
                    <div class="d-none d-md-none justify-content-center align-items-center px-0   asideToggle"
                        style="width: 40px;height: 40px;">
                        <span class="fal fa-bars font-4 cursor-pointer"></span>
                    </div>
                </div>
            </div>
            

            @include('components.aside-menu')

        </div>
        <div class="main-content in-active" style="overflow: hidden;" id="app">
            <div class="col-12 px-0 d-flex justify-content-between top-nav"
                style="height: 55px;background: var(--background-1);position: fixed;width: 100%;width: calc(100% - 260px);z-index: 99;border-bottom: 1px solid var(--border-color);">
                <div class="col-12 px-0 d-flex justify-content-center align-items-center btn  asideToggle"
                    style="width: 55px;height: 55px;">
                    <span class="fal fa-bars font-4"></span>
                </div>
                <div class="col-12 px-0 d-flex justify-content-end" style="height: 60px;">

                    <div class="col-12 px-0 d-flex justify-content-center align-items-center dropdown"
                        style="width: 55px;height: 55px;">
                        <div style="width: 55px;height: 55px;cursor: pointer;" data-bs-toggle="dropdown"
                            aria-expanded="false"
                            class="d-flex justify-content-center align-items-center cursor-pointer">
                            <i class="fi fi-{{ config('core.locale.languages')[app()->getLocale()]['flag']}} font-2"></i>
                        </div>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton1"
                            style="top: -3px;">
                            @foreach (collect(config('core.locale.languages'))->sortBy('name') as $code => $details)
                                @if ($code !== app()->getLocale())
                                    <x-utils.link 
                                    class="dropdown-item pt-1 pb-1" 
                                    :href="route('locale.change', $code)" 
                                    :text="__(\App\Helpers\MainHelper::getLocaleName($code))"  
                                    icon="fi fi-{{$details['flag']}}"/>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-12 px-0 d-flex justify-content-center align-items-center  dropdown"
                        style="width: 55px;height: 55px;">
                        <div style="width: 55px;height: 55px;cursor: pointer;" data-bs-toggle="dropdown"
                            aria-expanded="false"
                            class="d-flex justify-content-center align-items-center cursor-pointer">
                            <img src="{{ auth()->user()->getUserAvatar() }}"
                                style="padding: 10px;border-radius: 50%;width: 55px;height: 55px;">
                        </div>
                        <ul class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton2"
                            style="top: -3px;">

                            <li><a class="dropdown-item font-1" href="{{ route('admin.profile.index') }}"><span
                                        class="fal fa-user font-1"></span> {{ __('My profile')}}</a></li>

                            <li><a class="dropdown-item font-1" href="{{ route('admin.profile.edit') }}"><span
                                        class="fal fa-edit font-1"></span> {{ __('Edit my profile')}}</a></li>
                            <li>
                                <hr style="height: 1px;margin: 10px 0px 5px;">
                            </li>
                            <li><a class="dropdown-item font-1" href="#"
                                    onclick="document.getElementById('logout-form').submit();"><span
                                        class="fal fa-sign-out-alt font-1"></span> {{ __('Logout')}}</a></li>
                        </ul>
                    </div>

                    <div class="dropdown" style="width: 55px;height: 55px;background: #2381c6">
                        <span class="d-inline-block fal fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="col-12 px-0" style="margin-top: 55px;position: relative;">
                <div style="position:fixed;display: flex;align-items: center;justify-content: center;height: 100vh;background: var(--background-1);z-index: 10;margin-top: -15px;"
                    id="loading-image-container">
                    <img src="/images/loading.gif" style="position:fixed;width: 120px;max-width: 80%;margin-top: -60px;"
                        id="loading-image">
                </div>

                @yield('content')
            </div>
        </div>
    </div>

    @vite('resources/js/dashboard.js')
    {{ loadCurrentLocaleTranslations() }}

    @include('layouts.scripts')
    @yield('scripts')
    @stack('scripts')

</body>

</html>
