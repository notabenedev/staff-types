@extends("admin.layout")

@section("page-title", "{$unit->title} - ".config("staff-types.siteStaffParamUnitName"))

@section('header-title',  config("staff-types.siteStaffParamUnitName")." - {$unit->title}")


@section('admin')
    @include("staff-types::admin.staff-param-units.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.staff-param-units.update", ["unit" => $unit]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("put")

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               required
                               value="{{ old("title", $unit->title) }}"
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
                               value="{{ old("slug", $unit->slug) }}"
                               class="form-control @error("slug") is-invalid @enderror">
                        @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        @isset($types)
                            <label>{{ config("staff-types.siteStaffTypesName") }}:</label>
                            @include("staff-types::admin.staff-types.includes.tree-checkbox", ['types' => $types])

                        @endisset
                    </div>

                    <div class="my-3">
                        <hr>
                        <label>Название группы в файле выгрузки:</label>
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input"
                                   type="checkbox"
                                   {{ (old('demonstated_at') || $unit->demonstrated_at) ? "checked" : "" }}
                                   value="1"
                                   id="demonstratedBtn"
                                   name="demonstrated-btn">
                            <label class="custom-control-label" for="demonstratedBtn">
                                Отобразить
                            </label>
                        </div>
                    </div>

                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection