@foreach($items as $offer)
    <div class="card my-3">
        <div class="card-body">
            @includeIf("staff-types::site.staff-offers.teaser")
            @includeIf("staff-types::site.staff-params.includes.items",["available" => Notabenedev\StaffTypes\Facades\StaffParamActions::prepareAvailableData($offer)])
            @if(config("site-staff.employeeBtnName") && $offer->employee->btn_enabled)
                <a href="#" class="btn btn-outline-primary staff-employee__modal-btn"
                   data-bs-toggle="modal"
                   data-bs-target="#staffEmployeeModal"
                   data-bs-whatever="{{ $employee->title }} ({{ $offer->address }})"
                >
                    {{ config("site-staff.employeeBtnName") }}
                </a>
            @endif
        </div>
    </div>

@endforeach