<div class="col-12 px-0 pb-4 text-center justify-content-center align-items-center ">
    <a href="{{ route('admin.profile.edit') }}">

        <img src="{{ auth()->user()->getUserAvatar() }}"
            style="width: 80px;height: 80px;color: var(--background-1);border-radius: 50%"
            class="d-inline-block">
    </a>
    <div class="col-12 px-0 mt-2 text-center" style="color: #fff;">
        {{ __('Welcome') . ' ' . auth()->user()->name }}
    </div>
</div>
<div class="col-12 px-0">
    <div class="col-12 px-1 aside-menu" style="height: calc(100vh - 260px);overflow: auto;">
        <ul class="nav flex-column" id="nav_accordion">

            <li class="nav-item">
                <a href="{{ route('admin.index') }}" class="col-12 px-0">
                    <div class="col-12 item-container px-0 d-flex">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-home font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                            {{__('Home')}}
                        </div>
                    </div>
                </a>
            </li>
            
            @can('roles-read')
            <li class="nav-item">
                <a href="{{ route('admin.roles.index') }}" class="col-12 px-0">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-key font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                                {{__('Roles & Permessions')}} 
                        </div>
                    </div>
                </a>
            </li>
            @endcan
            
            @can('users-read')
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="col-12 px-0">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-users font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                                {{__('Users')}}
                        </div>
                    </div>
                </a>
            </li>
            @endcan

            @can('patients-read')
            <li class="nav-item">
                <a href="{{ route('admin.clinic.patients.index') }}" class="col-12 px-0">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-users font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                                {{__('Patients')}}
                        </div>
                    </div>
                </a>
            </li>
            @endcan

            @can('appointments-read')
            <li class="nav-item has-submenu">
                <a class="link" href="#">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-calendar-check font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title has-sub-menu">
                            {{  __('Appointments')}}
                        </div>
                    </div>
                </a>
                <ul class="submenu collapse">
                    <li class="py-1">
                        <a href="{{ route('admin.clinic.appointments.index') }}">
                            <div class="item-container-title">
                                <span style="width: 30px" class="fal fa-calendar-check font-2 px-1"> </span>
                                {{__('All apps')}}
                            </div>
                        </a>
                    </li>
                    <li class="py-1">
                        <a href="{{ route('admin.clinic.appointments.today-appointments') }}">
                            <div class="item-container-title">
                                <span style="width: 30px" class="fal fa-calendar-check font-2 px-1"> </span>
                                {{__('Today apps')}}
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('invoices-read')
            <li class="nav-item">
                <a href="{{ route('admin.clinic.invoices.index') }}" class="col-12 px-0">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-file-invoice font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                                {{__('Invoices')}}
                        </div>
                    </div>
                </a>
            </li>
            @endcan

            @can('prescriptions-read')
            <li class="nav-item">
                <a href="{{ route('admin.clinic.prescriptions.index') }}" class="col-12 px-0">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-file-prescription font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                                {{__('Prescriptions')}}
                        </div>
                    </div>
                </a>
            </li>
            @endcan
             @can('settings-update')
            <li class="nav-item has-submenu">
                <a class="link" href="#">
                    <div class="col-12 item-container px-0 d-flex ">
                        <div style="width: 50px" class="px-1 text-center">
                            <span class="fal fa-wrench font-2"> </span>
                        </div>
                        <div style="width: calc(100% - 50px)" class="px-1 item-container-title has-sub-menu">
                            {{  __('Settings')}}
                        </div>
                    </div>
                </a>
                <ul class="submenu collapse">
                    @can('settings-update')
                    <li class="py-1">
                        <a href="{{ route('admin.settings.index') }}">
                            <div class="item-container-title">
                                <span style="width: 30px" class="fal fa-cog font-2 px-1"> </span>
                                {{__('General Settings')}}
                            </div>
                        </a>
                    </li>
                     @endcan
                </ul>  
            </li> 
             @endcan             
            <a href="#" class="col-12 px-0" onclick="document.getElementById('logout-form').submit();">
                <div class="col-12 item-container px-0 d-flex ">
                    <div style="width: 50px" class="px-1 text-center">
                        <span class="fal fa-sign-out-alt font-2"> </span>
                    </div>
                    <div style="width: calc(100% - 50px)" class="px-1 item-container-title">
                            {{__('Logout')}}
                    </div>
                </div>
            </a>
        </ul>
    </div>
</div>

@push('scripts')
<script type="module">
document.addEventListener("DOMContentLoaded", function(){
     console.log('test');
  document.querySelectorAll('.aside-menu .link').forEach(function(element){
    element.addEventListener('click', function (e) {
        console.log('test');
      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;	
        if(nextEl) {
            e.preventDefault();	
            let mycollapse = new bootstrap.Collapse(nextEl);
            
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
}); 
// DOMContentLoaded  end
</script>
@endpush