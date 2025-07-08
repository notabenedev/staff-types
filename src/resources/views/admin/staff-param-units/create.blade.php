@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffParamUnitName")." - создать")

@section('header-title', config("staff-types.siteStaffParamUnitName")." - создать")

@section('admin')
    @include("staff-types::admin.staff-param-units.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @php($route = route("admin.staff-param-units.store"))
                <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
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
                               value="{{ old('slug') }}"
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
                                   {{ old('demonstrated_at') ? "checked" : "" }}
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
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection