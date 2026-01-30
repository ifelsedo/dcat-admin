<?php

namespace Dcat\Admin\Grid\Actions;

use Dcat\Admin\Grid\RowAction;

class QuickShow extends RowAction
{
    public function title()
    {
        if ($this->title) {
            return $this->title;
        }

        return '<i class="feather icon-search"></i> '.__('admin.quick_show').' &nbsp;&nbsp;';
    }

    public function render()
    {
        [$width, $height] = $this->parent->option('dialog_show_area');

        $title = trans('admin.show');

        \Dcat\Admin\Show::dialog($title)
            ->click(".{$this->getElementClass()}")
            ->dimensions($width, $height)
            ->forceRefresh();

        $this->setHtmlAttribute([
            'data-url' => $this->parent->urlWithConstraints("{$this->resource()}/{$this->getKey()}"),
        ]);

        return parent::render();
    }

    public function makeSelector()
    {
        return 'quick-show';
    }
}
