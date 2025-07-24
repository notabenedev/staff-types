@foreach($items as $offer)
    <div class="card my-3">
        <div class="card-body">
            @includeIf("staff-types::site.staff-offers.teaser")
            @includeIf("staff-types::site.staff-params.includes.items",["available" => Notabenedev\StaffTypes\Facades\StaffParamActions::prepareAvailableData($offer)])
        </div>
    </div>

@endforeach