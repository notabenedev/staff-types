<ul class="list-unstyled">
    @foreach ($types as $type)
        <li>
            <div class="form-check">
                <input class="form-check-input @error("check-$type->id") is-invalid @enderror"
                       type="checkbox"
                       {{ ((! count($errors->all()) ) && (isset($unit) && $unit->hasType($type->id))) || old('check-' . $type->id) ? "checked" : "" }}
                       value="{{ $type->id }}"
                       id="check-{{ $type->id }}"
                       name="check-{{ $type->id }}">
                <label class="form-check-label" for="check-{{ $type->id }}">
                    <span class="{{ ! $type->exported_at ? "text-secondary" : "text-body" }}"
                       target="_blank">
                        {{ $type->title }}
                    </span>
                </label>
                @error('check-' . $type->id)
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

        </li>
    @endforeach
</ul>

