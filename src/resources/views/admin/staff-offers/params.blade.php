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
                <staff-params
                        csrf-token="{{ csrf_token() }}"
                        post-url="{{ route('admin.vue.staff-params.post', ['id' => $offer->id, 'model' => 'staff-offer']) }}"
                        get-url="{{ route('admin.vue.staff-params.get', ['id' => $offer->id, 'model' => 'staff-offer']) }}"
                        get-available-url="{{ route('admin.vue.staff-params.available', ['id' => $offer->id, 'model' => 'staff-offer']) }}">
                </staff-params>
            </div>
        </div>
    </div>
@endsection