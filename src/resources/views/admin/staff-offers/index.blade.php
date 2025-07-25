@extends("admin.layout")

@section("page-title", config("staff-types.siteStaffOffersName")." - ")

@section('header-title')
    @empty($employee)
        {{  config("site-staff.siteEmployeeName") }}
    @else
        {{  config("site-staff.siteEmployeeName")  }} - {{ $employee->title }} - {{ config("staff-types.siteStaffEmployeeOffersName") }}
    @endempty
@endsection

@section('admin')
    @isset($employee)
        @include("staff-types::admin.staff-offers.includes.pills")
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

                    <select class="custom-select mb-2 me-sm-2" name="published" aria-label="Статус публикации">
                        <option value="all"{{ ! $request->has('published') || $request->get('published') == 'all' ? " selected" : '' }}>
                            Статус любой
                        </option>
                        <option value="yes"{{ $request->get('published') === 'yes' ? " selected" : '' }}>
                            Опубликован
                        </option>
                        <option value="no"{{ $request->get('published') === 'no' ? " selected" : '' }}>
                            Не опубликован
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
                            @empty($employee)
                                <th>{{ config("staff-types.siteSatffOffersName")  }}</th>
                            @endempty
                            <th>Тип</th>
                            <th>Статус</th>
                            @canany(["update", "view", "delete"], \App\SatffOffer::class)
                                <th>Действия</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($offers as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->type? $item->type->title: "" }}</td>
                                @empty($employee)
                                    <td>
                                        <a href="{{ route("admin.employees.show", ["employee" => $item->employee]) }}" target="_blank">
                                            {{ $item->employee->title }}
                                        </a>
                                    </td>
                                @endempty
                                <td>
                                    {{ !empty($item->published_at)? "Опубликован": "-" }}
                                </td>
                                @canany(["update", "view", "delete"], $item)
                                    <td>
                                        <div role="toolbar" class="btn-toolbar">
                                            <div class="btn-group mr-1">
                                                @can("update", $item)
                                                    <a href="{{ route("admin.staff-offers.edit", ["offer" => $item]) }}" class="btn btn-primary">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can("view", $item)
                                                    <a href="{{ route('admin.staff-offers.show', ['offer' => $item]) }}" class="btn btn-dark">
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
                                                <template v-if="true">
                                                    <form action="{{ route('admin.staff-offers.destroy', ['offer' => $item]) }}"
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
    @if ($offers->lastPage() > 1)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    {{ $offers->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection