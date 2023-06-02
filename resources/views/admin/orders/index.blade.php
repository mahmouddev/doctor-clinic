@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <!-- breadcrumb -->
        <x-bread-crumb :breads="[
                ['url' => url('/admin') , 'title' => __('Admin panel') , 'isactive' => false],
                ['url' => route('admin.orders.index') , 'title' => __('Orders') , 'isactive' => true],
            ]">
        </x-bread-crumb>
        <!-- /breadcrumb -->
        <div class="col-12 col-lg-12 p-0 main-box">

            <div class="col-12 px-0">
                <div class="col-12 p-0 row">
                    <div class="col-12 col-lg-4 py-3 px-3">
                        <span class="fas fa-shopping-cart"></span> {{ __('Orders') }}
                    </div>
                    <div class="col-12 col-lg-4 p-0">
                    </div>
                    <div class="col-12 col-lg-4 p-2 text-lg-end">
                        @can('orders-create')
                            <a href="{{ route('admin.orders.create') }}">
                                <span class="btn btn-primary"><span class="fas fa-plus"></span> {{ __('Add') }}</span>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="col-12 divider" style="min-height: 2px;"></div>
            </div>

            <div class="col-12 py-2 px-2 row">
                <div class="col-12 col-lg-4 p-2">
                    <form method="GET" class="accept-submit">
                        <input type="text" name="q" class="form-control" placeholder="{{ __('Search') }}"
                            value="{{ request()->get('q') }}">
                    </form>
                </div>
            </div>
            <div class="col-12 p-3" style="overflow:auto">
                <div class="col-12 p-0">
                    <table class="table table-bordered  table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>{{ __('Order number') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Order type') }}</th>
                                <th>{{ __('Total') }}</th>
                                <th>{{ __('Tax') }}</th>
                                <th>{{ __('Shipping') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>

                            </tr>
                        </thead>
                        <tbody id="sortable-table">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="ui-state-default drag-handler" data-order="{{ $order->id }}">
                                        {{ $order->id }}</td>
                                    <td>
                                        {{ $order->branch->name ?? '--' }}
                                    </td>
                                    <td>{{ __($order->order_type) }}</td>
                                    <td>{{ $order->total_price }}</td>
                                    <td>{{ $order->taxes }}</td>
                                    <td>{{ $order->shipping }}</td>
                                    <td>{{ __($order->status) }}</td>
                                    <td>
                                        @can('orders-update')
                                        @if ($order->status == 'unpaid')
                                            <pay-order-btn
                                                action="{{ route('admin.orders.update', $order) }}"
                                                csrf="{{ csrf_token() }}"
												total="{{ $order->total_price}}"></pay-order-btn>
                                        @endif
                                        @endcan
                                        @can('orders-delete') 
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                            class="d-inline-block">@csrf @method('DELETE')
                                            <button class="btn  btn-outline-danger btn-sm font-1 mx-1"
                                                onclick="var result = confirm('{{ __('Are sure of the deleting process ?')}}');if(result){}else{event.preventDefault()}">
                                                <span class="fas fa-trash "></span> {{ __('Delete')}}
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 p-3">
                {{ $orders->appends(request()->query())->render() }}
            </div>
        </div>
    </div>
@endsection
