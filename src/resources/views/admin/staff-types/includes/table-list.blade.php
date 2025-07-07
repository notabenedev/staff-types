<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Заголовок</th>
            <th>Адресная строка</th>
            @canany(["edit", "view", "delete"], \App\StaffType::class)
                <th>Действия</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach ($types as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                @canany(["edit", "view", "delete"], \App\StaffType::class)
                    <td>
                        <div role="toolbar" class="btn-toolbar">
                            <div class="btn-group me-1">
                                @can("update", \App\StaffType::class)
                                    <a href="{{ route("admin.staff-types.edit", ["type" => $item]) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can("view", \App\StaffType::class)
                                    <a href="{{ route('admin.staff-types.show', ["type" => $item]) }}" class="btn btn-dark">
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endcan
                                @can("delete", \App\StaffType::class)
                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                            </div>
                            @can("update", \App\StaffType::class)
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-{{ $item->exported_at ? "success" : "secondary" }}" data-confirm="{{ "export-form-{$item->id}" }}">
                                        <i class="fas fa-toggle-{{ $item->exported_at ? "on" : "off" }}"></i>
                                    </button>
                                </div>
                            @endcan
                        </div>
                        @can("update", \App\StaffType::class)
                            <confirm-form :id="'{{ "export-form-{$item->id}" }}'" text="Это изменит статус выгрузки в файл экспорта!" confirm-text="Да, изменить!">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-types.export', ["type" => $item]) }}"
                                          id="export-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("put")
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                        @can("delete", \App\StaffType::class)
                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.staff-types.destroy', ["type" => $item]) }}"
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
            @canany(["edit", "view", "delete"], \App\StaffType::class)
                <td colspan="3">
            @else
                <td colspan="2">
            @endcanany

                </td>
        </tr>
        </tbody>
    </table>
</div>