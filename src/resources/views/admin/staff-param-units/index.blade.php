@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffParamUnitsName")." - ".config("staff-types.sitePackageName")." - ")

@section('header-title', config("staff-types.siteStaffParamUnitsName"))

@section('admin')
    @include("staff-types::admin.staff-param-units.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @include("staff-types::admin.staff-param-units.includes.table-list", ["units" => $units])
            </div>
        </div>
    </div>
@endsection