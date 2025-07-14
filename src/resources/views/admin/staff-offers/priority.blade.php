@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffOffersName")." - ".config("staff-types.sitePackageName")." - ")

@section('header-title')
        {{ config("site-staff.siteEmployeeName").' - '.$employee->title.' - '.config("staff-types.siteStaffEmployeeOffersName")  }}
@endsection
@section('admin')
    @include("staff-types::admin.staff-offers.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <universal-priority
                        :elements="{{ json_encode($groups) }}"
                        url="{{ route("admin.vue.priority", ["table" => "staff_offers", "field" => "priority"]) }}">
                </universal-priority>
            </div>
        </div>
    </div>
@endsection