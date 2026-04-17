@if ($grid->allowPagination())
    <div class="box-footer d-block clearfix @if ($top) mt-1 pb-0 @endif">
        {!! $grid->paginator()->render() !!}
    </div>
@endif
