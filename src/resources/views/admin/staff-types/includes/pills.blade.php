@if (! empty($type))
    @include("staff-types::admin.staff-types.includes.breadcrumb")
@endif
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\StaffType::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.staff-types.index") }}"
                           class="nav-link{{ $currentRoute == "admin.staff-types.index" ? " active":"" }}">
                            {{ config("staff-types.sitePackageName") }}
                        </a>
                    </li>
                @endcan

                @empty($type)
                    @can("create", \App\StaffType::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-types.create") }}"
                               class="nav-link{{ $currentRoute === "admin.staff-types.create" ? " active" : "" }}">
                                Добавить
                            </a>
                        </li>
                    @endcan
                @else
                    @can("create", \App\StaffType::class)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               data-bs-toggle="dropdown"
                               href="#"
                               role="button"
                               aria-haspopup="true"
                               aria-expanded="false">
                                Добавить
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{ route('admin.staff-types.create') }}">
                                    Основную
                                </a>
                            </div>
                        </li>
                    @endcan

                    @can("view", $type)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-types.show", ["type" => $type]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-types.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $type)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-types.edit", ["type" => $type]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-types.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan


                    @can("delete", $type)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-type-{$type->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-type-{$type->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-types.destroy', ['type' => $type]) }}"
                                          id="delete-form-type-{{ $type->id }}"
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