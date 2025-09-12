<div class="col-12">
    <div class="mb-3">
        <label for="staffEmployeeAddress">Адрес приема<span class="text-danger">*</span></label>
        <input id="staffEmployeeAddress"
               name="address"
               @isset($address)
               value="{{ $address }}"
               @else
               placeholder="Адрес приема"
               @endisset
               required
               readonly
               class="form-control">
    </div>
</div>