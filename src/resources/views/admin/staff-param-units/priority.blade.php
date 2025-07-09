@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffParamUnitsName")." - ".config("staff-types.sitePackageName")." - ")

@section('header-title')
        {{ config("staff-types.siteStaffParamUnitsName") }}
@endsection
@section('admin')
    @include("staff-types::admin.staff-param-units.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <universal-priority
                        :elements="{{ json_encode($groups) }}"
                        url="{{ route("admin.vue.priority", ["table" => "staff_param_units", "field" => "priority"]) }}">
                </universal-priority>
            </div>
        </div>
    </div>
@endsection