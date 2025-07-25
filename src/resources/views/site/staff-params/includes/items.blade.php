<dl class="row">
    @foreach($available as $type => $units)
        @foreach($units as $unit)
            @if ($unit['demonstrated'] && count($unit['names']))
                <dd class="col-12 text-secondary">
                    <h2>{{ $unit['title'] }}</h2>
                </dd>
            @endif
            @foreach($unit['sets'] as $setId)
                <dd>
                @foreach($unit['names'] as $name)
                    @foreach($name['values'] as $set => $value)
                        @if ($set == $setId)
                                <dd class="col-sm-5 text-secondary">
                                    {{ $name['title'] }}:
                                </dd>
                                <dd class="col-sm-7">
                            @if($name['value_type'] == 'bool')
                                @if ( $value['value'] == 'true')
                                            Да
                                    @else
                                            -
                                @endif
                                @else
                                        {{ $value['value'] }}
                            @endif
                        @endif
                    @endforeach
                @endforeach
                @if (! $loop->last)
                    <hr class="border-light">
                @endif
                </dd>
            @endforeach
            @if (! $loop->last && $unit['demonstrated'])
                    <hr class="border-secondary">
            @endif
        @endforeach
    @endforeach
</dl>