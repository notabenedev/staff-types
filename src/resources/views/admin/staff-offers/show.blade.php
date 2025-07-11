@extends("admin.layout")

@section("page-title", "{$offer->title} - ")

@section('header-title',config("site-staff.siteEmployeeName").' - '.$employee->title.' - '.config("staff-types.siteStaffEmployeeOffersName")." - {$offer->title}")

@section('admin')
    @include("staff-types::admin.staff-offers.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    @if ($offer->price)
                        <dt class="col-sm-3">Стоимость</dt>
                        <dd class="col-sm-9">
                            {{ empty($offer->from_price) ? "" :"ОТ" }} {{ $offer->price }} {{ $offer->currency_human  }}
                        </dd>
                    @endif
                    @if ($offer->old_price)
                        <dt class="col-sm-3">Старая стоимость </dt>
                        <dd class="col-sm-9">
                            {{ $offer->old_price }} {{ $offer->currecy_human  }}
                        </dd>
                    @endif
                    <dt class="col-sm-3">Комментарий к стоимости:</dt>
                    <dd class="col-sm-9">
                        {{ empty($offer->sales_notes)? :  $offer->sales_notes }}
                    </dd>
                    <dt class="col-sm-3">Лет опыта:</dt>
                    <dd class="col-sm-9">
                        {{ $offer->experience }}
                    </dd>
                    <dt class="col-sm-3">Город работы:</dt>
                    <dd class="col-sm-9">
                        {{ $offer->city }}
                    </dd>
                    <dt class="col-sm-3">Адрес работы:</dt>
                    <dd class="col-sm-9">
                        {{ $offer->address }}
                    </dd>
                    <dt class="col-sm-3">Статус:</dt>
                    <dd class="col-sm-9">
                        {{ $offer->published_at ?  "Опубликован" : "-"}}
                    </dd>
                    <dt class="col-sm-3">Описание:</dt>
                    <dd class="col-sm-9">
                        {!! $offer->description !!}
                    </dd>
                </dl>
            </div>
        </div>
    </div>


@endsection