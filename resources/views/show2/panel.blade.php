@if($title || $tools)
<div class="box-header with-border" style="padding: .65rem 1rem">
    <h3 class="box-title" style="line-height:30px;">{!! $title !!}</h3>
    <div class="pull-right">{!! $tools !!}</div>
</div>
@endif
<div class="box-body">
    @if($rows->isEmpty())
        @foreach($fields as $field)
        {{-- {!! $field->render() !!} --}}
        {{-- {!! $field->wrap(false)->setView('admin.show.field')->render() !!} --}}
        {{-- {!! $field->view('admin.show.field') !!} --}}
        {{-- {!! view('admin.show.field', $field->variables()) !!} --}}
        @php
        $reflectionClass = new ReflectionClass($field);
        $property = $reflectionClass->getProperty('view');
        $property->setAccessible(true);
        $property->setValue($field, 'admin.show.field');
        @endphp
        {!! $field->wrap(false)->render() !!}
        @endforeach
    @else
        <div class="row">
            @foreach($rows as $k => $row)
                {{-- @if($k % 2 == 0) --}}
                    {{-- <div class="row"> --}}
                {{-- @endif --}}
                {{-- {!! $row->render() !!} --}}
                {!! view('admin.show.row', ['fields' => $row->fields()]) !!}
                {{-- @if($k % 2 == 1) --}}
                    {{-- </div> --}}
                {{-- @endif --}}
            @endforeach
        </div>
    @endif
    <div class="clearfix"></div>
</div>