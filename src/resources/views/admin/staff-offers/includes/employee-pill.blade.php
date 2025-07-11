@can("viewAny", \App\StaffOffer::class)
    <li class="nav-item">
        <a class="nav-link{{ str_contains($currentRoute , ".staff-offers.") ? ' active' : '' }}"
           href="{{ route('admin.employees.show.staff-offers.index', ['employee' => $employee]) }}">
            {{ config("staff-types.siteStaffEmployeeOffersName") }}
        </a>
    </li>
@endcan