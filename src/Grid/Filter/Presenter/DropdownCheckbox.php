<?php

namespace Dcat\Admin\Grid\Filter\Presenter;

use Illuminate\Contracts\Support\Arrayable;

class DropdownCheckbox extends DropdownRadio
{
    /**
     * 自定义视图模板
     */
    protected $view = 'admin::filter.dropdown-checkbox';

    protected function prepare()
    {
    }
}
