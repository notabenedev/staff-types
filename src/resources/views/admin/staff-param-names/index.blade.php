@extends("admin.layout")

@section("page-title", "Параметры группы - ")

@section('header-title')
    @empty($unit)
        {{  config("staff-types.siteStaffParamUnitName") }}
    @else
        {{  config("staff-types.siteStaffParamUnitName")  }} - {{ $unit->title }} - {{  config("staff-types.siteStaffParamNamesName")  }}
    @endempty
@endsection

@section('admin')
    @isset($unit)
        @include("staff-types::admin.staff-param-names.includes.pills")
    @endisset
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <form action="{{ $fromRoute }}" method="get" class="d-lg-inline-flex">
                    
                    <label for="title" class="sr-only">Заголовок</label>
                    <input type="text"
                           id="title"
                           name="title"
                           placeholder="Заголовок"
                           value="{{ $request->get("title", "") }}"
                           class="form-control  mb-2 me-sm-2">

                    <select class="custom-select mb-2 me-sm-2" name="expected" aria-label="Статус публикации">
                        <option value="all"{{ ! $request->has('expected') || $request->get('expected') == 'all' ? " selected" : '' }}>
                            Статус любой
                        </option>
                        <option value="yes"{{ $request->get('expected') === 'yes' ? " selected" : '' }}>
                            Обязательный
                        </option>
                        <option value="no"{{ $request->get('expected') === 'no' ? " selected" : '' }}>
                            Не обязательный
                        </option>
                    </select>

                    <button class="btn btn-primary mb-2 me-2" type="submit">Применить</button>
                    <a href="{{ $fromRoute }}" class="btn btn-secondary mb-2">
                        Сбросить
                    </a>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Заголовок</th>
                            @empty($unit)
                                <th>Группа параметров</th>
                            @endempty
                            <th>Обязательный</th>
                            @canany(["update", "view", "delete"], \App\StaffParamName::class)
                                <th>Действия</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($names as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                @empty($unit)
                                    <td>
                                        <a href="{{ route("admin.staff-param-units.show", ["unit" => $item->unit]) }}" target="_blank">
                                            {{ $item->unit->title }}
                                        </a>
                                    </td>
                                @endempty
                                <td>
                                    {{ !empty($item->expected_at)? "Обязательный": "-" }}
                                </td>
                                @canany(["update", "view", "delete"], $item)
                                    <td>
                                        <div role="toolbar" class="btn-toolbar">
                                            <div class="btn-group mr-1">
                                                @can("update", $item)
                                                    <a href="{{ route("admin.staff-param-names.edit", ["name" => $item]) }}" class="btn btn-primary">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can("view", $item)
                                                    <a href="{{ route('admin.staff-param-names.show', ['name' => $item]) }}" class="btn btn-dark">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can("delete", $item)
                                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </div>

                                        @can("delete", $item)
                                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                                <template>
                                                    <form action="{{ route('admin.staff-param-names.destroy', ['name' => $item]) }}"
                                                          id="delete-form-{{ $item->id }}"
                                                          class="btn-group"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                    </form>
                                                </template>
                                            </confirm-form>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if ($names->lastPage() > 1)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    {{ $names->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection