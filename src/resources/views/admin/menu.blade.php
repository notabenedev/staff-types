@if (class_exists(\App\StaffType::class))
    <a href="{{ route('admin.staff-types.index') }}"
       class="collapse-item{{strstr($currentRoute, 'admin.staff-types') !== FALSE ? ' active' : '' }}">
        <span>{{ config("staff-types.siteStaffTypesName") }}</span>
    </a>
@endif
@if (class_exists(\App\StaffParamUnit::class))
    <a href="{{ route('admin.staff-param-units.index') }}"
       class="collapse-item{{strstr($currentRoute, 'admin.staff-param-units') !== FALSE ? ' active' : '' }}">
        <span>{{ config("staff-types.siteStaffParamUnitsName") }}</span>
    </a>
@endif