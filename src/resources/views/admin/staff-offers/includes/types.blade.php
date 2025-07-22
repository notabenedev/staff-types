<select name="staff_type_id" class="form-control custom-select @error("staff_type_id") is-invalid @enderror">
    @foreach($types as $type)
        <option value="{{ $type->id }}" @if ((!empty($offer) && ($offer->staff_type_id == $type->id || $offer->staff_type_id == $old)) || $loop->first ) selected @endif>
            {{ $type->title }}
        </option>
    @endforeach
</select>
@error("staff_type_id")
<div class="invalid-feedback" role="alert">
        {{ $message }}
</div>
@enderror