@extends("admin.layout")

@section("page-title", "{$unit->title} - ". config("staff-types.siteStaffParamUnitName"))

@section('header-title',  config("staff-types.siteStaffParamUnitName")." - {$unit->title}")

@section('admin')
    @include("staff-types::admin.staff-param-units.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Заголовок</dt>
                    <dd class="col-sm-9">{{ $unit->title }}</dd>
                    @if ($unit->slug)
                        <dt class="col-sm-3">Адрес</dt>
                        <dd class="col-sm-9">{{ $unit->slug }}</dd>
                    @endif
                    <dt class="col-sm-3">Название группы в файле выгрузки</dt>
                    <dd class="col-sm-9">{{ $unit->demonstrated_at? "Отобразить" : "Не отображать" }}</dd>

                </dl>
            </div>
        </div>
    </div>

    @if ($names)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ config("staff-types.siteStaffParamNamesName") }}</h5>
                    {{--                    <a href="{{ route("admin.staff-param-names.names-tree", ["unit" => $unit]) }}">{{ config("staff-types.siteStaffParamNamesName") }} - Приоритет</a>--}}
                </div>
                {{--                @include("staff-types::admin.staff-param-names.includes.table-list", ["namesList" => $names])--}}
            </div>
        </div>
    @endif


    @if ($types)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5>{{ config("staff-types.siteStaffTypesName") }}</h5>
                </div>
                <div class="card-body">
                    <ul class="mb-3">
                    @foreach($types as $item)
                        <li>{{ $item->title }}</li>
                    @endforeach
                    </ul>
                </div>

            </div>
        </div>
    @endif

@endsection