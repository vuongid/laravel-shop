<div class="mb-3">
    <div class="form-label">{{ $label }}</div>
    <select {{ $attributes->merge(['class' => 'form-select']) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $keyOp => $valueOp)
            <option value="{{ $keyOp }}" {{ $keyOp == $value ? 'selected' : '' }}>
                {{ $valueOp }}
            </option>
        @endforeach
    </select>
</div>
