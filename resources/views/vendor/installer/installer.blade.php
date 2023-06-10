@extends('vendor.installer.layouts.master')
@section('template_title')
    Doctor Clinic Installer
@endsection

@section('title')
    Doctor Clinic Installer
@endsection
@section('style')
    <style>
        .box {
            width: 525px !important;
        }

        .left-form {
            width: 50%;
            margin-right: 10px;
        }

        .right-form {
            width: 50%;
        }

        .row {
            display: flex;
        }
    </style>
@endsection
@section('container')
    <installer></installer>
@endsection
@section('b-script')
    <script>
        window.installer = {
            requirements_url:          "{{ route('requirements') }}",
            login_url:                 "{{ route('login') }}",
            permissions_url:           "{{ route('permissions') }}",
            complete_installation_url: "{{ route('complete-installation') }}",
            test_connection_url:       "{{ route('test-connection') }}",
            is_sub_directory:          "{{ $sub_directory }}",
            timezones: JSON.parse('{!! $timezones !!}'),
            host: "{{ $host }}",
        }
    </script>
@endsection
