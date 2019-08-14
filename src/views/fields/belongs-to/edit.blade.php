<div class="form-group">
    <label for="{{ $field->name() }}" class="@error($field->name()) text-danger @enderror">
        {{ \Illuminate\Support\Str::ucfirst($field->displayText()) }}
    </label>
    <select class="form-control @error($field->name()) is-invalid @enderror"
            id="{{ $field->name() }}"
            name="{{ $field->name() }}"
            @if($field->readonly()) readonly @endif>
        @php($selectedValue = old($field->name(), $result->{$field->name()} ? $result->{$field->name()}->id : null))
        @foreach($field->options() as $value => $text)
            <option value="{{ $value }}" @if($selectedValue === $value) selected @endif>{{ $text }}</option>
        @endforeach
    </select>
    @error($field->name())
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
