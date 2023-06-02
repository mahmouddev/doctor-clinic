@extends('layouts.admin')
@section('content')
    <div class="col-12 p-3">
        <!-- breadcrumb -->
        <x-bread-crumb :breads="[
            ['url' => url('/admin'), 'title' => __('Admin panel'), 'isactive' => false],
            ['url' => route('admin.orders.index'), 'title' => __('Orders'), 'isactive' => false],
            ['url' => '#', 'title' => __('Add'), 'isactive' => true],
        ]">
        </x-bread-crumb>
        <div class="col-12 col-lg-12 p-0 ">
           
                <div class="col-12 col-lg-12 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> {{ __('Add') }}
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>

                    <create-order 
                        :csrf='{{ json_encode(csrf_token()) }}'
                        :action='{{ json_encode(route("admin.orders.store")) }}'
                        :items='@json($items)'
                        :branches='@json($branches)'
                        :taxes='@json($taxes)'>
                    </create-order>

                       
                </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="module">

</script>
@endsection
