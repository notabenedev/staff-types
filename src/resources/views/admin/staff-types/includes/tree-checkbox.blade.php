<ul class="list-unstyled">
    @foreach ($types as $type)
        <li>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input"
                       type="checkbox"
                       {{ (! count($errors->all()) ) && (isset($unit) && $unit->hasType($type->id)) || old('check-' . $type->id) ? "checked" : "" }}
                       value="{{ $type->id }}"
                       id="check-{{ $type->id }}"
                       name="check-{{ $type->id }}">
                <label class="custom-control-label" for="check-{{ $type->id }}">
                    <span class="{{ ! $type->exported_at ? "text-secondary" : "text-body" }}"
                       target="_blank">
                        {{ $type->title }}
                    </span>
                </label>
            </div>
        </li>
    @endforeach
</ul>

