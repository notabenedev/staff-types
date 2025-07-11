<select name="currency" class="form-control custom-select @error("currency") is-invalid @enderror">
    @foreach(\App\StaffOffer::CURRENCY_VARIANTS as $key => $title)
        <option value="{{ $key }}" @if ((!empty($offer) && ($offer->currency === $key || $offer->currency == $old)) || $loop->first ) selected @endif>
            {{ $title }}
        </option>
    @endforeach
</select>
@error("currency")
<div class="invalid-feedback" role="alert">
        {{ $message }}
</div>
@enderror