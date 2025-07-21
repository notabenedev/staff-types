@extends("admin.layout")

@section("page-title", "{$type->title} - ".config("staff-types.siteStaffTypeName"))

@section('header-title',  config("staff-types.siteStaffTypeName")." - {$type->title}")


@section('admin')
    @include("staff-types::admin.staff-types.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.staff-types.update", ["type" => $type]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("put")

                    <div class="form-group">
                        <label for="title">Заголовок <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               required
                               value="{{ old("title", $type->title) }}"
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
                               value="{{ old("slug", $type->slug) }}"
                               class="form-control @error("slug") is-invalid @enderror">
                        @error("slug")
                            <div class="invalid-feedback" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label>{{ config("site-staff.siteDepartmentName") }}:</label>
                        @include("site-staff::admin.departments.includes.tree-checkbox")
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