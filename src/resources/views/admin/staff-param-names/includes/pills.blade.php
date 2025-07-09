@include("staff-types::admin.staff-param-units.includes.pills")
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\StaffParamName::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.staff-param-units.staff-param-names.index", ["unit" => $unit]) }}"
                           class="nav-link{{ $currentRoute === "admin.staff-param-units.staff-param-names.index" ? " active" : "" }}">
                            Список
                        </a>
                    </li>
                @endcan

                @can("create", \App\StaffParamName::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.staff-param-units.staff-param-names.create", ["unit" => $unit]) }}"
                           class="nav-link{{ $currentRoute === "admin.staff-param-units.staff-param-names.create" ? ' active':''}}">
                            Добавить параметр
                        </a>
                    </li>

                @endcan

                @if (! empty($name))
                    @can("view", $name)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-param-names.show", ["name" => $name]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-param-names.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $name)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-param-names.edit", ["name" => $name]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-param-names.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("delete", $name)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-name-{$name->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-name-{$name->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-param-names.destroy', ['name' => $name]) }}"
                                          id="delete-form-name-{{ $name->id }}"
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