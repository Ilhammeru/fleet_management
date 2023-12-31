@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header d-flex align-items-center justify-content-between">
                    <div class="page-header__title">
                        <p>@lang('global.createOrder')</p>
                    </div>

                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
                        @lang('global.back')
                    </a>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        @foreach ($forms as $form)
                            <x-form.form-group
                                :name="$form['name']"
                                :label="$form['label']"
                                :input-type="isset($form['inputType']) ? $form['inputType'] : ''"
                                :class-name="isset($form['className']) ? $form['className'] : null"
                                :is-required="isset($form['isRequired']) ? $form['isRequired'] : false"
                                :placeholder="isset($form['placeholder']) ? $form['placeholder'] : null"
                                :select-options="isset($form['selectOptions']) ? $form['selectOptions'] : null"
                                :field-type="isset($form['fieldType']) ? $form['fieldType'] : 'input'"
                                :show-error-component="isset($form['showErrorComponent']) ? $form['showErrorComponent'] : true"
                                :value="isset($form['value']) ? $form['value'] : null"
                                :radio-options="isset($form['radioOptions']) ? $form['radioOptions'] : null"
                                :form-model="isset($form['formModel']) ? $form['formModel'] : null"
                                :input-description="isset($form['inputDescription']) ? $form['inputDescription'] : null"></x-form.form-group>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ mix('dist/order.js') }}"></script>

    <script>
        $(document).ready(function() {
            initSelect2();
        });
    </script>
@endpush
