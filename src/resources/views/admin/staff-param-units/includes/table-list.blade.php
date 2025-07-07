<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Заголовок</th>
            <th>Адресная строка</th>
            @canany(["edit", "view", "delete"], \App\StaffParamUnit::class)
                <th>Действия</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach ($units as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                @canany(["edit", "view", "delete"], \App\StaffParamUnit::class)
                    <td>
                        <div role="toolbar" class="btn-toolbar">
                            <div class="btn-group me-1">
                                @can("update", \App\StaffParamUnit::class)
                                    <a href="{{ route("admin.staff-param-units.edit", ["unit" => $item]) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can("view", \App\StaffParamUnit::class)
                                    <a href="{{ route('admin.staff-param-units.show', ["unit" => $item]) }}" class="btn btn-dark">
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endcan
                                @can("delete", \App\StaffParamUnit::class)
                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                            </div>
                            @can("update", \App\StaffParamUnit::class)
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-{{ $item->demonstrated_at ? "success" : "secondary" }}" data-confirm="{{ "demonstrate-form-{$item->id}" }}">
                                        <i class="fas fa-toggle-{{ $item->demonstrated_at ? "on" : "off" }}"></i>
                                    </button>
                                </div>
                            @endcan
                        </div>
                        @can("update", \App\StaffParamUnit::class)
                            <confirm-form :id="'{{ "demonstrate-form-{$item->id}" }}'" text="Это изменит статус выгрузки в файл экспорта!" confirm-text="Да, изменить!">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-param-units.demonstrate', ["unit" => $item]) }}"
                                          id="demonstrate-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("put")
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                        @can("delete", \App\StaffParamUnit::class)
                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-param-units.destroy', ["unit" => $item]) }}"
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
        <tr class="text-center">
            @canany(["edit", "view", "delete"], \App\StaffParamUnit::class)
                <td colspan="3">
            @else
                <td colspan="2">
            @endcanany

                </td>
        </tr>
        </tbody>
    </table>
</div>