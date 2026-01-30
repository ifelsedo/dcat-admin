<script>Dcat.wait();</script>

<style>
    .show-content .row {
        margin-right: 0;
        margin-left: 0;
    }
</style>

{{--必须在静态资源加载前，用section先渲染 content--}}
@section('content')
    <section class="show-content">{!! $content !!}</section>
@endsection

 {!! Dcat\Admin\Admin::asset()->cssToHtml() !!}
 {!! Dcat\Admin\Admin::asset()->jsToHtml() !!}

 {!! Dcat\Admin\Admin::asset()->styleToHtml() !!}

 @yield('content')

 {!! Dcat\Admin\Admin::asset()->scriptToHtml() !!}
<div class="extra-html">{!! Dcat\Admin\Admin::html() !!}</div>
