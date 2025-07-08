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
                        </div>

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