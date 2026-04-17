<style>
    .border-bottom-dark {
        border-bottom: 1px solid #dee2e6;
    }

    td.grid__actions__ {
        display: none !important;
    }
</style>
<div class="dcat-box">

    <div class="d-block pb-0">
        @include('admin::grid.table-toolbar')
    </div>

    {!! $grid->renderFilter() !!}

    {!! $grid->renderHeader() !!}

    @if ($grid->allowTopPagination())
    {!! $grid->renderPagination('top') !!}
    @endif
    
    <div class="{!! $grid->formatTableParentClass() !!}">

        <div class="table-scroll-container" style="max-height: 600px; overflow-y: auto; position: relative; ">
            <table class="{{ $grid->formatTableClass() }}" id="{{ $tableId }}" style="margin-bottom: 0;">
                <thead style="position: sticky; top: 0; background-color: #f8f9fa; z-index: 10; border: 2px solid #dee2e6;">
                @if ($headers = $grid->getVisibleComplexHeaders())
                    <tr>
                        @foreach($headers as $header)
                            {!! $header->render() !!}
                        @endforeach
                    </tr>
                @endif
                <tr>
                    @foreach($grid->getVisibleColumns() as $column)
                        <th {!! $column->formatTitleAttributes() !!}>{!! $column->getLabel() !!}{!! $column->renderHeader() !!}</th>
                    @endforeach
                </tr>
                </thead>

                @if ($grid->hasQuickCreate())
                    {!! $grid->renderQuickCreate() !!}
                @endif

                <tbody>
                @foreach($grid->rows() as $row)
                    <tr {!! $row->rowAttributes() !!}>
                        @foreach($grid->getVisibleColumnNames() as $name)
                            <td {!! $row->columnAttributes($name) !!}>{!! $row->column($name) !!}</td>
                        @endforeach
                    </tr>
                @endforeach
                @if ($grid->rows()->isEmpty())
                    <tr>
                        <td colspan="{!! count($grid->getVisibleColumnNames()) !!}">
                            <div style="margin:5px 0 0 10px;"><span class="help-block" style="margin-bottom:0"><i class="feather icon-alert-circle"></i>&nbsp;{{ trans('admin.no_data') }}</span></div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    {!! $grid->renderFooter() !!}

    @if ($grid->allowBottomPagination())
    {!! $grid->renderPagination('bottom') !!}
    @endif

</div>

<script>
$(document).ready(function() {
    let lastScrollTop = 0;
    let hasTriggered = false;

    // 监听表格容器的滚动事件
    $('.table-scroll-container').on('scroll', function() {
        var currentScrollTop = $(this).scrollTop();

        // 检测是否从顶部开始向下滚动
        if (lastScrollTop === 0 && currentScrollTop > 0 && !hasTriggered) {
            hasTriggered = true;

            // 将浏览器滚动条滚到页面底部
            $('html, body').animate({
                scrollTop: $(document).height() - $(window).height()
            }, 500);

            // 延迟重置标志，避免重复触发
            setTimeout(function() {
                hasTriggered = false;
            }, 1000);
        }

        // 如果滚动回到顶部，重置状态
        if (currentScrollTop === 0) {
            hasTriggered = false;
        }

        lastScrollTop = currentScrollTop;
    });
});
</script>