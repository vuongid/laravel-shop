<div class="mb-3">
    @if (!empty($label))
        <label class="form-label">{{ $label }}</label>
    @endif
    <input {{ $attributes->merge(['class' => 'form-control']) }}>
</div>
