@php
    // $width = $width ?? ['label' => 4, 'field' => 8];
    $width = ['label' => 3, 'field' => 9];
@endphp

<div class="col-md-4">
    <div class="row">
    <div class="col-sm-{{ $width['label'] }} control-label text-right">
        <span>{{ $label }}</span>
    </div>

    <div class="box-body col-sm-{{ $width['field'] }}">
        @if($wrapped)
            <div class="box box-solid box-default no-margin box-show">
                <div class="box-body">
                    @if($escape)
                        {{ $content }}
                    @else
                        {!! $content !!}
                    @endif
                    &nbsp;
                </div>
            </div>
        @else
            @if($escape)
                {{ $content }}
            @else
                {!! $content !!}
            @endif
        @endif
    </div>
    </div>
</div>
