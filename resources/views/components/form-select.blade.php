@props([
    'label',
    'name',
    'options' => [],
    'value' => '',
    'required' => false,
    'placeholder' => 'Seleccione una opción',
])

<div class="mb-3">

    <label for="{{ $name }}" class="form-label">

        {{ $label }}

        @if($required)
            <span class="text-danger">*</span>
        @endif

    </label>

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'form-select' . ($errors->has($name) ? ' is-invalid' : '')
        ]) }}
    >

        <option value="">

            {{ $placeholder }}

        </option>

        @foreach($options as $key => $text)

            <option
                value="{{ $key }}"
                @selected(old($name, $value) == $key)
            >

                {{ $text }}

            </option>

        @endforeach

    </select>

    @error($name)

        <div class="invalid-feedback">

            {{ $message }}

        </div>

    @enderror

</div>