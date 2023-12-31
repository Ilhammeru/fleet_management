<div class="sidebar-wrapper">
    <div class="sidebar-wrapper__header">
        <div class="sidebar-wrapper__header__item">
            <img src="{{ asset('assets/icons/logo-transparent.png') }}" alt="">
        </div>
    </div>
    <div class="sidebar-wrapper__body">
        @can('dashboard')
            <div class="sidebar-wrapper__body__item {{ request()->route()->uri == 'dashboard' ? 'active' : '' }}">
                <img src="{{ asset('assets/icons/dashboard.png') }}" alt="">
                <p>@lang('global.dashboard')</p>
            </div>
        @endcan

        @can('approve-order')
            <div class="sidebar-wrapper__body__item {{ request()->route()->uri == 'approval' ? 'active' : '' }}">
                <img src="{{ asset('assets/icons/approve.png') }}" alt="">
                <p>@lang('global.approval')</p>
            </div>
        @endcan

        @can('list-order')
            @php
                $active = '';
                if(request()->route()->getName() == 'orders') {
                    $active = 'active';
                }
            @endphp
            <div class="sidebar-wrapper__body__item {{ $active }}"
                onclick="sidebarNavigation('{{ route('orders.index') }}')">
                <img src="{{ asset('assets/icons/order.png') }}" alt="">
                <p>@lang('global.orders')</p>
            </div>
        @endcan

        <div class="sidebar-title">
            <p>@lang('global.masterData')</p>
        </div>

        <div class="sidebar-wrapper__body__item {{ request()->route()->uri == 'vehicles' ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/vehicle.png') }}" alt="">
            <p>@lang('global.vehicles')</p>
        </div>

        @php
            $active = '';
            if(request()->route()->getName() == 'master.vehicle-brands') {
                $active = 'active';
            }
        @endphp
        <div class="sidebar-wrapper__body__item {{$active}}"
            onclick="sidebarNavigation('{{ route('master.vehicle-brands') }}')">
            <img src="{{ asset('assets/icons/brand.png') }}" alt="">
            <p>@lang('global.vehicleBrand')</p>
        </div>
        <div class="sidebar-wrapper__body__item {{ request()->route()->uri == 'vehicle-models' ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/model.png') }}" alt="">
            <p>@lang('global.vehicleModel')</p>
        </div>
        <div class="sidebar-wrapper__body__item {{ request()->route()->uri == 'offices' ? 'active' : '' }}">
            <img src="{{ asset('assets/icons/office.png') }}" alt="">
            <p>@lang('global.offices')</p>
        </div>
    </div>
</div>
