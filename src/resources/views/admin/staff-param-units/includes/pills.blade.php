@if (! empty($unit))
    @include("staff-types::admin.staff-param-units.includes.breadcrumb")
@endif
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\StaffParamUnit::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.staff-param-units.index") }}"
                           class="nav-link{{ $currentRoute == "admin.staff-param-units.index" ? " active":"" }}">
                            {{ config("staff-types.siteStaffParamUnitsName") }}
                        </a>
                    </li>
                @endcan
                    @can("update", \App\StaffParamUnit::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-param-units.priority") }}"
                               class="nav-link{{ $currentRoute === "admin.staff-param-units.priority" ? " active" : "" }}">
                                Приоритет
                            </a>
                        </li>
                    @endcan
                    @can("create", \App\StaffParamUnit::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-param-units.create") }}"
                               class="nav-link{{ $currentRoute === "admin.staff-param-units.create" ? " active" : "" }}">
                                Добавить
                            </a>
                        </li>
                    @endcan

                @if (! empty($unit))
                    @can("view", $unit)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-param-units.show", ["unit" => $unit]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-param-units.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $unit)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-param-units.edit", ["unit" => $unit]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-param-units.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("viewAny", \App\StaffParamName::class)
                            <li class="nav-item">
                                <a href="{{ route("admin.staff-param-units.staff-param-names.index", ["unit" => $unit]) }}"
                                   class="nav-link{{ strstr($currentRoute, "staff-param-names.") !== false ? " active" : "" }}">
                                    Параметры
                                </a>
                            </li>
                    @endcan

                    @can("delete", $unit)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-type-{$unit->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-type-{$unit->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-param-units.destroy', ['unit' => $unit]) }}"
                                          id="delete-form-type-{{ $unit->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("delete")
                                    </form>
                                </template>
                            </confirm-form>
                        </li>
                    @endcan
                @endif
            </ul>
        </div>
    </div>
</div>