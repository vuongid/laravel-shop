@php
    $isInvalid = $errors->has($attributes->get('name')) ? 'is-invalid' : '';
@endphp

<div class="mb-3">
    @if ($label || count($labelAttributes) > 0)
        <label
            {{ $attributes->only('id')->merge($labelAttributes)->class(['form-label', $attributes->has('required') ? 'required' : '']) }}>
            {{ $label }}
        </label>
    @endif
    <input {{ $attributes->merge(['class' => "form-control $isInvalid"]) }} />
    @error($attributes->get('name'))
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
