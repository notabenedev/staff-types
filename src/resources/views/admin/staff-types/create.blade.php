@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffTypeName")." - создать")

@section('header-title', config("staff-types.siteStaffTypeName")." - создать")

@section('admin')
    @include("staff-types::admin.staff-types.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @php($route = empty($type) ? route("admin.staff-types.store") : route("admin.staff-types.store-child", ["type" => $type]))
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

                    <div class="btn-group"
                         role="group">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection