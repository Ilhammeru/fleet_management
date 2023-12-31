<!-- Form Group -->
<div class="form-group row">
    <div class="col-md-3">
        <label for="{{ $name }}" class="form-label {{ $isRequired }}">{{ $label }}</label>
    </div>
    <div class="col-md-6">
        @if ($fieldType == 'input')
            <input type="{{ $inputType }}"
                name="{{ $name }}"
                class="form-control {{ $className }}"
                placeholder="{{ $placeholder }}"
                id="{{ $name }}"
                autocomplete="off"
                value="{{ $value }}">
        @elseif($fieldType == 'select')
            <select name="{{ $name }}"
                id="{{ $name }}"
                class="form-control">
                <option value=""></option>
                @if ($selectOptions)
                    @foreach ($selectOptions as $option)
                        @php
                            $selected = '';
                            if (isset($option['selected'])) {
                                $selected = $option['selected'];
                            }
                        @endphp
                        <option value="{{ $option['id'] }}" {{ $selected }}>{{ $option['text'] }}</option>
                    @endforeach
                @endif
            </select>
        @elseif($fieldType == 'radio')
            <div class="w-100">
                <div class="d-flex align-items-center">
                    @foreach ($radioOptions as $key => $radioOption)
                        <div class="api-scopes-button {{ $radioOption['className'] }} {{ $key == 0 ? 'active' : '' }}"
                            id="{{ $radioOption['id'] }}"
                            @if (count($radioOptions) == 2)
                                style="border-right: 1px solid #e6e6e6;"
                            @endif>
                            {{ $radioOption['label'] }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="{{ $radioOption['name'] }}" id="{{ $radioOption['name'] }}" value="{{ $radioOptions[0]['value'] }}">
            </div>
        @endif
        @if ($showErrorComponent)
            <div class="invalid-feedback" data-error="{{ $name }}"></div>
            <div class="input-description conjunction" id="conjunction-{{ $name }}" style="display: none;">-</div>
        @endif
        @if ($inputDescription)
            <div class="input-description">{{ $inputDescription }}</div>
        @endif
    </div>
</div> <!-- End Form Group -->
