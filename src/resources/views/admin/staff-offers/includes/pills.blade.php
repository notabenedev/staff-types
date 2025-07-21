@include("site-staff::admin.employees.pills")
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\StaffOffer::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.employees.show.staff-offers.index", ["employee" => $employee]) }}"
                           class="nav-link{{ $currentRoute === "admin.employees.show.staff-offers.index" ? " active" : "" }}">
                            Список
                        </a>
                    </li>
                @endcan
                @can("update", \App\StaffOffer::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.employees.show.staff-offers.priority",["employee" => $employee]) }}"
                               class="nav-link{{ $currentRoute === "admin.employees.show.staff-offers.priority" ? " active" : "" }}">
                                Приоритет
                            </a>
                        </li>
                @endcan
                @can("create", \App\StaffOffer::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.employees.show.staff-offers.create", ["employee" => $employee]) }}"
                           class="nav-link{{ $currentRoute === "admin.employees.show.staff-offers.create" ? ' active':''}}">
                            Добавить предложение
                        </a>
                    </li>

                @endcan

                @if (! empty($offer))
                    @can("view", $offer)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-offers.show", ["offer" => $offer]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-offers.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $offer)
                        <li class="nav-item">
                            <a href="{{ route("admin.staff-offers.edit", ["offer" => $offer]) }}"
                               class="nav-link{{ $currentRoute === "admin.staff-offers.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("viewAny", \App\StaffParam::class)
                            <li class="nav-item">
                                <a href="{{ route("admin.staff-offers.params", ["offer" => $offer]) }}"
                                   class="nav-link{{ strstr($currentRoute, "staff-offers.params") !== false ? " active" : "" }}">
                                    {{  config("staff-types.siteStaffParamsName")  }}
                                </a>
                            </li>
                    @endcan

                    @can("delete", $offer)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-name-{$offer->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-name-{$offer->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-offers.destroy', ['offer' => $offer]) }}"
                                          id="delete-form-name-{{ $offer->id }}"
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