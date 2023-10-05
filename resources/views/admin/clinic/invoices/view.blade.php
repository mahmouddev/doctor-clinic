@extends('layouts.admin')
@section('styles')
    <style type="text/css">
       
        .card-footer-btn {
            display: flex;
            align-items: center;
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
        }

        .text-uppercase-bold-sm {
            text-transform: uppercase !important;
            font-weight: 500 !important;
            letter-spacing: 2px !important;
            font-size: 0.85rem !important;
        }

        .hover-lift-light {
            transition: box-shadow 0.25s ease, transform 0.25s ease,
                color 0.25s ease, background-color 0.15s ease-in;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .btn-group-lg>.btn,
        .btn-lg {
            padding: 0.8rem 1.85rem;
            font-size: 1.1rem;
            border-radius: 0.3rem;
        }

        .btn-dark {
            color: #fff;
            background-color: #1e2e50;
            border-color: #1e2e50;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(30, 46, 80, 0.09);
            border-radius: 0.25rem;
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .p-5 {
            padding: 3rem !important;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.5rem 1.5rem;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }

        .table td,
        .table th {
            border-bottom: 0;
            border-top: 1px solid #edf2f9;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 1rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }

        .px-0 {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .table thead th,
        tbody td,
        tbody th {
            vertical-align: middle;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .icon-circle[class*="text-"] [fill]:not([fill="none"]),
        .icon-circle[class*="text-"] svg:not([fill="none"]),
        .svg-icon[class*="text-"] [fill]:not([fill="none"]),
        .svg-icon[class*="text-"] svg:not([fill="none"]) {
            fill: currentColor !important;
        }

        .svg-icon>svg {
            width: 1.45rem;
            height: 1.45rem;
        }
    </style>
@endsection
@section('content')
    <div class="col-12 p-3">

        <div class="col-12 col-lg-12 p-0 ">
            <div class="container  mt-6 mb-7" id="invoice">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-xl-7">
                        <div class="card">
                            <div class="card-body p-5">
                                <h2>{{__("Hey")}} {{ $invoice->appointment->patient->name}},</h2>
                                <p class="fs-sm">
                                    {!!  __('This is the receipt for a payment of :price (USD) you made to us.' , ['price' => "<strong>$.{$invoice->total_price}</strong>" ]) !!}
                                </p>
                                <div class="border-top border-gray-200 pt-4 mt-4">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="text-muted mb-2">{{ __('Payment No.') }}</div>
                                            <strong>#{{ $invoice->id}}</strong>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="text-muted mb-2">{{ __('Payment Date') }}</div>
                                            <strong>{{ $invoice->created_at->toDateString()}}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top border-gray-200 mt-4 py-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-muted mb-2">{{ __('Patient') }}</div>
                                            <strong> {{ $invoice->appointment->patient->name}} </strong>
                                            
                                        </div>
                                        {{-- <div class="col-md-6 text-md-end">
                                            <div class="text-muted mb-2">Payment To</div>
                                            <strong> Themes LLC </strong>
                                        </div> --}}
                                    </div>
                                </div>
                                <table class="table border-bottom border-gray-200 mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm px-0">
                                                {{__('Description')}}
                                            </th>
                                            <th scope="col" class="fs-sm text-dark text-uppercase-bold-sm text-end px-0">
                                                {{__('AMOUNT')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="px-0">{{ $invoice->appointment->type}}</td>
                                            <td class="text-end px-0">${{ $invoice->total_price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-5">
                                    <div class="d-flex justify-content-end">
                                        <p class="text-muted me-3">{{ __('Subtotal')}}:</p>
                                        <span>${{ $invoice->total_price }}</span>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <p class="text-muted me-3">{{ __('Discount')}}:</p>
                                        <span>-${{ number_format(($invoice->discount ?? 0.00), 2, '.', ' ') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <h5 class="me-3">{{ __('Total')}}:</h5>
                                        <h5 class="text-success">${{ number_format(($invoice->total_price - ($invoice->discount ?? 0.00)), 2, '.', ' ')  }} USD</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container  mt-6 mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-xl-7">
                        <a href="#!" data-print
                            class="btn btn-dark btn-lg card-footer-btn justify-content-center text-uppercase-bold-sm hover-lift-light">
                            <span class="svg-icon text-white me-2 px-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24"/></svg>
                            </span>
                            {{ __('Print')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@section('scripts')
<script type="module">
$(document).ready(function() { 
   $('[data-print]').on('click', function (e) { 
        e.preventDefault();
        var printContents = document.getElementById('invoice').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

    });
});

</script>
@endsection
