<select name="value_type" class="form-control custom-select">
    @foreach(\App\StaffParamName::ALLOW_TYPES as $type => $title)
        <option value="{{ $type }}" @if ((!empty($name) && ($name->value_type === $type || $name->value_type == $old)) || $loop->first ) selected @endif>
            {{ $title }}
        </option>
    @endforeach
</select>