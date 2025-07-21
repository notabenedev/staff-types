@extends("admin.layout")

@section("page-title", "{$type->title} - ". config("staff-types.siteStaffTypeName"))

@section('header-title',  config("staff-types.siteStaffTypeName")." - {$type->title}")

@section('admin')
    @include("staff-types::admin.staff-types.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Заголовок</dt>
                    <dd class="col-sm-9">{{ $type->title }}</dd>
                    @if ($type->slug)
                        <dt class="col-sm-3">Адрес</dt>
                        <dd class="col-sm-9">{{ $type->slug }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    @if ($units)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ config("staff-types.siteStaffParamUnitsName") }}</h5>
                </div>
                <div class="card-body">
                    <ul class="my-3">
                        @foreach($units as $item)
                            <li>{{ $item->title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @if ($departments)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ config("site-staff.siteDepartmentName") }}</h5>
                </div>
                <div class="card-body">
                    <ul class="my-3">
                        @foreach($departments as $item)
                            <li>{{ $item->title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


@endsection