@extends("admin.layout")

@section("page-title", "{$unit->title} - ")

@section('header-title', "{$unit->title}")

@section('admin')
    @include("staff-types::admin.staff-param-names.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.staff-param-units.staff-param-names.store", ["unit" => $unit]) }}" method="post">
                    @csrf

                    <div class="form-group">
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

                    <div class="form-group">
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

                    <div class="form-group">
                        <label for="name">Имя в выгрузке</label>
                        <input type="text"
                               id="name"
                               maxlength="150"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error("name") is-invalid @enderror">
                        @error("name")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="value_type">Тип значения <span class="text-danger">*</span></label>
                        @include('staff-types::admin.staff-param-names.includes.value-types', ['name' => null, 'old' => old('value_type')])
                        @error("value_type")
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <hr>
                        <label>Статус параметра (для файла выгрузки):</label>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input"
                                   type="checkbox"
                                   {{ old('expected_at') ? "checked" : "" }}
                                   value="1"
                                   id="expectedBtn"
                                   name="expected-btn">
                            <label class="custom-control-label" for="expectedBtn">
                                Обязательный
                            </label>
                        </div>
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