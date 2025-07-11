<select name="contact_id" class="form-control custom-select @error("contact_id") is-invalid @enderror">
        <option value="null">Адрес не выбран</option>
    @foreach($contacts as $item)
        <option value="{{ $item->id }}" @if ((!empty($offer) && ($offer->contact_id === $item->id || $offer->contact_id == $old)) || $loop->first ) selected @endif>
            {{ $item->address ? : $item->title }}
        </option>
    @endforeach
</select>
@error("contact_id")
<div class="invalid-feedback" role="alert">
        {{ $message }}
</div>
@enderror