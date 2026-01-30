@php
    // 检测是否处于 quickShow (DialogShow) 模式
    $isQuickShow = request('_dialog_show_') || request()->query('_dialog_show_');
    
    // quickShow 模式下强制单列，否则使用设置的列数
    $columns = $isQuickShow ? 1 : ($columnsPerRow ?? 1);
    $colWidth = $columns > 0 ? floor(12 / $columns) : 12;
@endphp

@if(!$disableHeader && ($title || $tools))
<div class="box-header with-border" style="padding: .65rem 1rem">
    <h3 class="box-title" style="line-height:30px;">{!! $title !!}</h3>
    <div class="pull-right">{!! $tools !!}</div>
</div>
@endif
<div class="box-body">
    @if($rows->isEmpty())
        {{-- 没有使用 row()，按 columnsPerRow 分组显示 --}}
        @php
            $fieldArray = $fields->values()->all();
            $totalFields = count($fieldArray);
        @endphp
        @for($i = 0; $i < $totalFields; $i += $columns)
            <div class="row">
                @for($j = $i; $j < min($i + $columns, $totalFields); $j++)
                    <div class="col-md-{{ $colWidth }}">
                        {!! $fieldArray[$j]->wrap(false)->addVariables(['width' => 12])->render() !!}
                    </div>
                @endfor
            </div>
        @endfor
    @else
        {{-- 使用了 row()，按 row 渲染，但每个字段根据 columnsPerRow 分配宽度 --}}
        @foreach($rows as $row)
            @php
                $rowFields = $row->fields();
                $rowFieldCount = count($rowFields);
            @endphp
            @if($isQuickShow)
                {{-- quickShow 模式下，每个字段单独一行 --}}
                @foreach($rowFields as $field)
                    <div class="row">
                        <div class="col-md-12">
                            {!! $field['element']->wrap(false)->addVariables(['width' => 12])->render() !!}
                        </div>
                    </div>
                @endforeach
            @else
                {{-- 普通模式，按 columnsPerRow 分组 --}}
                @for($i = 0; $i < $rowFieldCount; $i += $columns)
                    <div class="row">
                        @for($j = $i; $j < min($i + $columns, $rowFieldCount); $j++)
                            <div class="col-md-{{ $colWidth }}">
                                {!! $rowFields[$j]['element']->wrap(false)->addVariables(['width' => 12])->render() !!}
                            </div>
                        @endfor
                    </div>
                @endfor
            @endif
        @endforeach
    @endif
    <div class="clearfix"></div>
</div>
