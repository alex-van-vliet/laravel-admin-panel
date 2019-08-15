<div class="form-group form-check">
    <input id="{{ $field->name() }}"
           name="{{ $field->name() }}"
           type="checkbox"
           class="form-check-input @error($field->name()) is-invalid @enderror"
           @if(old($field->name())) checked @endif
           value="true">
    <label for="{{ $field->name() }}" class="form-check-label">
        {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
    </label>
    @error($field->name())
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
