@extends('vendor.installer.layouts.master')
@section('template_title')
    {{ env("EN_APP_NAME") }} Installer
@endsection

@section('title')
    {{ env("EN_APP_NAME") }} Installer
@endsection
@section('style')
@endsection
@section('container')
    <installer></installer>
@endsection
@section('b-script')
    <script>
        window.installer = {
            requirements_url:          "{{ route('server-components') }}",
            login_url:                 "{{ route('login') }}",
            permissions_url:           "{{ route('directory-permissions') }}",
            complete_installation_url: "{{ route('complete-installation') }}",
            test_connection_url:       "{{ route('check-db-connection') }}",
            is_sub_directory:          "{{ $sub_directory }}",
            timezones: JSON.parse('{!! $timezones !!}'),
            host: "{{ $host }}",
        }
    </script>
@endsection
