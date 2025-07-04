@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffTypeName")." - ".config("staff-types.sitePackageName")." - ")

@section('header-title', config("staff-types.siteStaffTypeName"))

@section('admin')
    @include("staff-types::admin.staff-types.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include("staff-types::admin.staff-types.includes.table-list", ["types" => $types])
            </div>
        </div>
    </div>
@endsection