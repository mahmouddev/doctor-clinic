<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<div class="col-12 fixed-top  main-nav shadow" style="background: #fff;padding: 3px 0px;min-height: 65px;">
    <div class="container px-1 my-auto">
        <div class="col-12 row p-0">
            <div class="col-auto p-3 d-flex align-items-center hover-main-color-flexable" onclick="document.getElementById('aside-menu').classList.toggle('active');document.getElementById('body-overlay').classList.toggle('active');" style="cursor: pointer;">
                <span class="far fa-bars font-3 px-0"></span>
            </div>
        
            <div class="col me-auto p-0 row justify-content-between d-flex">
                <div class="col row m-0 px-2">
                </div>

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
            </div>
        </div>
    </div>
</div>
