<dl class="row">
    @foreach($available as $type => $units)
        @foreach($units as $unit)
            @if ($unit['demonstrated'] && count($unit['names']) && count($unit['sets']))
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
                                </dd>
                        @endif
                    @endforeach
                @endforeach
                @if (! $loop->last)
                        <dd class="border-bottom border-light-subtle my-0 mx-2"></dd>
                @endif
                </dd>
            @endforeach
        @endforeach
    @endforeach
</dl>