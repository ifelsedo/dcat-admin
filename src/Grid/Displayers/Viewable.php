<?php

namespace Dcat\Admin\Grid\Displayers;

use Dcat\Admin\Admin;
use Dcat\Admin\Support\Helper;

/**
 * Class Viewable.
 *
 * 默认隐藏值，点击眼睛图标展示值
 */
class Viewable extends AbstractDisplayer
{
    protected function addScript()
    {
        $script = <<<'JS'
$('.grid-column-viewable').off('click').on('click', function (e) {
    var $content = $(this).siblings('.viewable-content');
    var $masked = $(this).siblings('.viewable-masked');

    if ($content.is(':visible')) {
        $content.hide();
        $masked.show();
        $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    } else {
        $content.show();
        $masked.hide();
        $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    }
});
JS;
        Admin::script($script);
    }

    public function display()
    {
        $this->addScript();

        $this->value = Helper::htmlEntityEncode($this->value);

        $html = <<<HTML
<a href="javascript:void(0);" class="grid-column-viewable text-muted" title="{$this->trans('click_to_view')}" data-placement="bottom">
    <i class="fa fa-eye"></i>
</a>&nbsp;<span class="viewable-masked" style="position: relative; top: 3px">******</span><span class="viewable-content" style="display: none;">{$this->value}</span>
HTML;

        return $this->value === '' || $this->value === null ? $this->value : $html;
    }
}
