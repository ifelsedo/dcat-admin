<?php

namespace Dcat\Admin\Grid\Filter\Presenter;

use Illuminate\Contracts\Support\Arrayable;

class DropdownRadio extends Presenter
{
    /**
     * 自定义视图模板
     */
    protected $view = 'admin::filter.dropdown-radio';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * 每行显示的选项数量
     * @var int
     */
    protected $itemsPerRow;


    /**
     * DropdownCheckbox constructor.
     *
     * @param  array  $options
     * @param  int  $itemsPerRow
     */
    public function __construct($options = [], $itemsPerRow = 1)
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        $this->options = (array) $options;
        $this->itemsPerRow = $itemsPerRow;

        return $this;
    }

    protected function prepare()
    {
    }

    /**
     * @return array
     */
    public function defaultVariables(): array
    {
        $this->prepare();

        return [
            'options'   => $this->options,
            'itemsPerRow' => $this->itemsPerRow,
        ];
    }
}
