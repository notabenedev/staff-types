@can("update", \App\StaffEmployee::class)
    @isset (config("staff-types.staffParamModels")["employee"])
        <li class="nav-item">
            <a class="nav-link{{ str_contains($currentRoute , ".employees.show.params") ? ' active' : '' }}"
               href="{{ route('admin.employees.show.params', ['employee' => $employee]) }}">
                Параметры
            </a>
        </li>
    @endisset
@endcan
@can("update", \App\StaffOffer::class)
    <li class="nav-item">
        <a class="nav-link{{ str_contains($currentRoute , ".staff-offers.") ? ' active' : '' }}"
           href="{{ route('admin.employees.show.staff-offers.index', ['employee' => $employee]) }}">
            {{ config("staff-types.siteStaffEmployeeOffersName") }}
        </a>
    </li>
@endcan