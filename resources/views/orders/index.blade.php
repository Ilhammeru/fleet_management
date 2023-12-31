@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header d-flex align-items-center justify-content-between">
                    <div class="page-header__title">
                        <p>@lang('global.orders')</p>
                    </div>

                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
                        @lang('global.create')
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ mix('dist/order.js') }}"></script>
@endpush
