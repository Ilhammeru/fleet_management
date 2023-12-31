<div class="form-group mb-1">
    <input type="{{ $inputType }}"
        class="form-control {{ $className }}"
        name="{{ $name }}"
        autocomplete="off"
        id="{{ $name }}" />

    <label for="{{ $name }}"
        class="{{ $isRequired }}">
        {{ $label }}
    </label>
</div>
<div class="input-helper-group mb-4">
    @if ($showErrorComponent)
        <div class="invalid-feedback" data-error="{{ $name }}"></div>
        <div class="input-description conjunction" id="conjunction-{{ $name }}" style="display: none;">-</div>
    @endif
    @if ($inputDescription)
        <div class="input-description">{{ $inputDescription }}</div>
    @endif
</div>
