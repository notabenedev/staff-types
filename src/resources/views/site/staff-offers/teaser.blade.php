@if($offer->published_at)
    <div class="staff-employee__offer" id="staffOffer{{ $offer->slug }}">
        <dl class="row">
            <dt class="col-12"><h2 class="text-secondary">{{ $offer->title }}</h2></dt>
            <dt class="col-12"><h3>{{ $offer->address }}</h3></dt>
            @if ($offer->price)
                <dd class="col-sm-5">{{ empty($offer->sales_notes)? "Стоимссть":  $offer->sales_notes }}</dd>
                <dt class="col-sm-7">
                    {{ empty($offer->from_price) ? "" :"от" }} {{ $offer->price }} {{ $offer->currency_human  }}
                    @if ($offer->old_price)
                        / <del class="text-muted">{{ $offer->old_price }}{{ $offer->currency_human  }}</del>
                    @endif
                </dt>
            @endif
            <dd class="col-sm-5">Опыт работы:</dd>
            <dt class="col-sm-7">
                {{ $offer->experience }}
                @switch($offer->experience)
                    @case(($offer->experience > 4 && $offer->experience < 21) || ($offer->experience > 20 && $offer->experience % 10 === 0 || $offer->experience % 10 > 4))
                    лет
                    @break
                    @case( min($offer->experience % 10, 5) === 1)
                    год
                    @break
                    @default
                    года
                    @break
                @endswitch

            </dt>

        </dl>
        <div class="staff-eemployee__offer-description">
            {!! $offer->description !!}
        </div>
    </div>
@endif
