@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header d-flex align-items-center justify-content-between">
                <div class="page-header__title">
                    <p>@lang('global.vehicleBrand')</p>
                </div>
            </div>

            <div class="table-wrapper mt-4">
                <div class="table-responsive">
                    <table class="table w-100" id="table-vehicle-brands">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Toyota</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Honda</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Hino</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#table-vehicle-brands').DataTable({
                columnDefs: [
                    {width: '5%', target: 0},
                    {width: '10%', target: 2, orderable: false},
                ]
            });
        });
    </script>
@endpush
