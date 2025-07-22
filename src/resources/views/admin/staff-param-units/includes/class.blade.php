<label for="class">Отображать группу для:</label>
<select class="form-control custom-select  @error("class") is-invalid @enderror" name="class" id="class">
@foreach(config("staff-types.staffParamModels") as $key => $value)
    <option value="{{ $key }}" @if ((!empty($unit) && ($unit->class === $key || $unit->class === $old))) selected  @endif>{{ $value }}</option>
@endforeach
</select>
