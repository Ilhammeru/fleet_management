@extends('layouts.auth')

@push('style')
    <link rel="stylesheet" href="{{ mix('dist/auth.css') }}">
@endpush

@section('content')
    <div class="auth-wrapper">
        <div class="left">
            <div class="image-wrapper">
                <img src="{{ asset('assets/icons/signin.png') }}" alt="">
            </div>
            <div class="left__title">
                <p>@lang('global.signInYourAccount')</p>
            </div>
        </div>
        <div class="right">
            <form id="form-login">
                <div class="form-wrapper">
                    <div class="logo-wrapper">
                        <img src="{{ asset('assets/icons/logo-transparent.png') }}" class="logo-img" alt="">
                        <div class="mobile-icon">
                            <img src="{{ asset('assets/icons/signin.png') }}" alt="">
                            <p>@lang('global.signInYourAccount')</p>
                        </div>
                    </div>

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

                    <div class="mt-5 mb-2">
                        <button class="btn btn-primary w-100"
                            type="button"
                            id="btn-login">
                            @lang('global.signIn')
                        </button>
                    </div>

                    <div class="forgot-password">
                        <a href="">@lang('global.forgotPassword')</a>
                    </div>

                    <div class="other-signin-option mt-3">
                        <p><span>@lang('global.orContinueWithOption')</span></p>
                    </div>

                    <div class="social-wrapper">
                        <div class="social-wrapper__item">
                            <img src="{{ asset('assets/icons/google.png') }}" alt="">
                        </div>
                        <div class="social-wrapper__item">
                            <img src="{{ asset('assets/icons/facebook.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ mix('dist/auth.js') }}"></script>
@endpush

