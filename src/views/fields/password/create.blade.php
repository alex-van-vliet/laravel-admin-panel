<div class="form-group">
    <label for="{{ $field->name() }}" class="@error($field->name()) text-danger @enderror">
        {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
    </label>
    <input id="{{ $field->name() }}"
           name="{{ $field->name() }}"
           type="password"
           class="form-control @error($field->name()) is-invalid @enderror">
    @error($field->name())
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
<div class="form-group">
    <label for="{{ $field->name() }}_confirmation">
        {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }} Confirmation
    </label>
    <input id="{{ $field->name() }}_confirmation"
           name="{{ $field->name() }}_confirmation"
           type="password"
           class="form-control">
</div>
