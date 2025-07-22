@extends("admin.layout")

@section("page-title", "{$employee->title} - ")

@section('header-title', config("site-staff.siteEmployeeName").' - '.$employee->title.' - '.config("staff-types.siteStaffEmployeeOffersName"))

@section('admin')
    @include("staff-types::admin.staff-offers.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.employees.show.staff-offers.store", ["employee" => $employee]) }}" method="post">
                    @csrf

                    <div class="my-3">
                        <label for="sales_notes">Тип</label>
                        @include('staff-types::admin.staff-offers.includes.types', ['offer' => null, 'old' => old('staff_type_id')])
                        @error("staff_type_id")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               maxlength="100"
                               required
                               value="{{ old('title') }}"
                               class="form-control @error("title") is-invalid @enderror">
                        @error("title")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="slug">Адресная строка</label>
                        <input type="text"
                               id="slug"
                               name="slug"
                               maxlength="100"
                               value="{{ old('slug') }}"
                               class="form-control @error("slug") is-invalid @enderror">
                        @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input"
                                   type="checkbox"
                                   {{ old('from_price') ? "checked" : "" }}
                                   value="1"
                                   id="fromPrice"
                                   name="from_price">
                            <label class="custom-control-label" for="fromPrice">
                                Стоимость ОТ
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="my-3">
                                <label for="price">Стоимость</label>
                                <input type="text"
                                       id="price"
                                       placeholder="0"
                                       maxlength="150"
                                       name="price"
                                       value="{{ old('price') }}"
                                       class="form-control @error("price") is-invalid @enderror">
                                @error("price")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="my-3">
                                <label for="old_price">Старая стоимость</label>
                                <input type="text"
                                       id="old_price"
                                       placeholder="0"
                                       maxlength="150"
                                       name="old_price"
                                       value="{{ old('old_price') }}"
                                       class="form-control @error("old_price") is-invalid @enderror">
                                @error("old_price")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="my-3">
                                <label for="currency">Валюта:</label>
                                @include('staff-types::admin.staff-offers.includes.currency', ['offer' => null, 'old' => old('currency')])
                                @error("currency")
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="my-3">
                        <label for="sales_notes">Комментарий</label>
                        @include('staff-types::admin.staff-offers.includes.sales-notes', ['offer' => null, 'old' => old('sales_notes')])
                        @error("sales_notes")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="experience">Лет опыта (целым числом)<span class="text-danger">*</span></label>
                        <input type="text"
                               id="experience"
                               placeholder="0"
                               maxlength="10"
                               name="experience"
                               required
                               value="{{ old('experience') }}"
                               class="form-control @error("experience") is-invalid @enderror">
                        @error("experience")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description">{{ config("site-staff.employeeDescriptionName") }}</label>
                        <textarea class="form-control tiny {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                  name="description"
                                  id="description"
                                  rows="3">
                            {{ old('description') }}
                        </textarea>
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="my-3">
                        <hr>
                        <label for="city">Город предложения<span class="text-danger">*</span></label>
                        <input type="text"
                               id="city"
                               maxlength="150"
                               name="city"
                               required
                               value="{{ old('city') }}"
                               class="form-control @error("city") is-invalid @enderror">
                        @error("city")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label>Адрес предложения</label>
                        @include("staff-types::admin.staff-offers.includes.contacts")
                    </div>

                    <div class="my-3">
                        <hr>
                        <label>Статус</label>
                        <div class="custom-control custom-checkbox @error("published-btn") is-invalid @enderror">
                            <input class="custom-control-input"
                                   type="checkbox"
                                   {{ old('published-btn') ? "checked" : "" }}
                                   value="1"
                                   id="publishedBtn"
                                   name="published-btn">
                            <label class="custom-control-label" for="publishedBtn">
                                Опубликовано
                            </label>
                        </div>
                        @error("piblished-btn")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection