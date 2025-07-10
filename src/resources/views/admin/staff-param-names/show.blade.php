@extends("admin.layout")

@section("page-title", "{$name->title} - ")

@section('header-title', config("staff-types.siteStaffParamUnitsName").' - '.$unit->title.' - '.config("staff-types.siteStaffParamNamesName")." - {$name->title}")

@section('admin')
    @include("staff-types::admin.staff-param-names.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    @if ($name->name)
                        <dt class="col-sm-3">Имя в выгрузке:</dt>
                        <dd class="col-sm-9">
                            {{ $name->name }}
                        </dd>
                    @endif
                    <dt class="col-sm-3">Тип значения:</dt>
                    <dd class="col-sm-9">
                        {{ $name->value_type_human }}
                    </dd>
                    <dt class="col-sm-3">Статус параметра:</dt>
                    <dd class="col-sm-9">
                        {{ $name->expected_at ?  "Обязательный" : "-"}}
                    </dd>
                </dl>
            </div>
        </div>
    </div>


@endsection