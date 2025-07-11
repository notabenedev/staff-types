<select name="sales_notes" class="form-control custom-select @error("sales_notes") is-invalid @enderror">
    @foreach(array_values(\App\StaffOffer::SALES_NOTES_VARIANTS) as $key => $value)
        <option value="{{ $value }}" @if ((!empty($offer) && ($offer->sales_notes == $value || $offer->sales_notes == $old)) || $loop->first ) selected @endif>
            {{ $value }}
        </option>
    @endforeach
</select>
@error("sales_notes")
<div class="invalid-feedback" role="alert">
        {{ $message }}
</div>
@enderror