<?php

namespace Dcat\Admin\Widgets;

use Dcat\Admin\Admin;
use Dcat\Admin\Show;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Support\Helper;
use Illuminate\Contracts\Support\Arrayable;

class DialogShow
{
    const QUERY_NAME = '_dialog_show_';

    public static $contentView = 'admin::layouts.show-content';

    protected $options = [
        'title'          => 'Show',
        'area'           => ['700px', '670px'],
        'defaultUrl'     => null,
        'buttonSelector' => null,
        'query'          => null,
        'lang'           => null,
        'forceRefresh'   => false,
    ];

    protected $handlers = [
        'shown'  => null,
        'hidden' => null,
    ];

    public function __construct(?string $title = null, $url = null)
    {
        $this->title($title);
        $this->url($url);
    }

    public function options($options = [])
    {
        if ($options instanceof Arrayable) {
            $options = $options->toArray();
        }

        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function title(?string $title)
    {
        $this->options['title'] = $title;

        return $this;
    }

    public function click(string $buttonSelector)
    {
        $this->options['buttonSelector'] = $buttonSelector;

        return $this;
    }

    public function forceRefresh()
    {
        $this->options['forceRefresh'] = true;

        return $this;
    }

    public function onShown(string $script)
    {
        $this->handlers['shown'] = $script;

        return $this;
    }

    public function onHidden(string $script)
    {
        $this->handlers['hidden'] = $script;

        return $this;
    }

    public function dimensions(string $width, string $height)
    {
        $this->options['area'] = [$width, $height];

        return $this;
    }

    public function width(?string $width)
    {
        $this->options['area'][0] = $width;

        return $this;
    }

    public function height(?string $height)
    {
        $this->options['area'][1] = $height;

        return $this;
    }

    public function url(?string $url)
    {
        if ($url) {
            $this->options['defaultUrl'] = Helper::urlWithQuery(
                admin_url($url),
                [static::QUERY_NAME => 1]
            );
        }

        return $this;
    }

    protected function render()
    {
        $this->setUpOptions();

        $opts = json_encode($this->options);

        Admin::script(
            <<<JS
(function () {
    var opts = {$opts};

    opts.shown = function (success, response) {
        {$this->handlers['shown']}
    };
    opts.hidden = function (success, response) {
        {$this->handlers['hidden']}
    };

    Dcat.DialogShow(opts);
})();
JS
        );
    }

    protected function setUpOptions()
    {
        $this->options['query'] = static::QUERY_NAME;
    }

    public static function is()
    {
        return request(static::QUERY_NAME) ? true : false;
    }

    public static function prepare(Show $show)
    {
        if (! static::is()) {
            return;
        }

        Admin::baseCss([], false);
        Admin::baseJs([], false);
        Admin::fonts(false);
        Admin::style('.show-content{ padding-top: 7px }');

        $show->disableHeader();
        $show->disableFooter();

        Content::composing(function (Content $content) {
            $content->view(static::$contentView);
        });
    }

    public function __destruct()
    {
        if ($results = Helper::render($this->render())) {
            Admin::html($results);
        }
    }
}
