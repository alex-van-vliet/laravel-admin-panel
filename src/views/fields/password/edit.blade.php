<div class="form-group">
    <label for="{{ $field->name() }}" class="@error($field->name()) text-danger @enderror">
        {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
    </label>
    <input id="{{ $field->name() }}"
           name="{{ $field->name() }}"
           type="{{ $field->type() }}"
           class="form-control @error($field->name()) is-invalid @enderror"
           @if($field->readonly()) readonly @endif>
    @error($field->name())
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
