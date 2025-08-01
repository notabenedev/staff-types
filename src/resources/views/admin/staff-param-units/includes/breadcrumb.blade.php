@php($namePage = ! empty($name))
<div class="col-12 mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach(\Notabenedev\StaffTypes\Facades\StaffParamUnitActions::getAdminBreadcrumb($unit, $namePage) as $item)
                <li class="breadcrumb-item{{ $item->active ? " active" : "" }}" aria-current="page">
                    @if ($item->active)
                        {{ $item->title }}
                    @else
                        <a href="{{ $item->url }}">
                            {{ $item->title }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>