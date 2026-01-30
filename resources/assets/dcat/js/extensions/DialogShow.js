
let w = window;

if (top && w.layer) {
    w = top;
}

export default class DialogShow {
    constructor(Dcat, options) {
        let self = this, nullFun = function () {};

        self.options = $.extend({
            title: '',
            defaultUrl: '',
            buttonSelector: '',
            area: [],
            lang: {},
            query: '',
            forceRefresh: false,
            shown: nullFun,
            hidden: nullFun,
        }, options);

        self.$target = null;
        self._dialog = w.layer;
        self._counter = 1;
        self._idx = {};
        self._dialogs = {};
        self.rendering = 0;

        self.init(options)
    }

    init(options) {
        let self = this,
            defUrl = options.defaultUrl,
            selector = options.buttonSelector;

        selector && $(selector).off('click').click(function () {
            self.$target = $(this);

            let counter = self.$target.attr('counter'), url;

            if (! counter) {
                counter = self._counter;

                self.$target.attr('counter', counter);

                self._counter++;
            }

            url = self.$target.data('url') || defUrl;

            if (url.indexOf('?') === -1) {
                url += '?' + options.query + '=1'
            } else if (url.indexOf(options.query) === -1) {
                url += '&' + options.query + '=1'
            }

            self._build(url, counter);
        });

        selector || setTimeout(function () {
            self._build(defUrl, self._counter)
        }, 400);
    }

    _build(url, counter) {
        let self = this,
            $btn = self.$target;

        if (! url || self.rendering) {
            return;
        }

        if (self._dialogs[counter]) {
            self._dialogs[counter].show();

            try {
                self._dialog.restore(self._idx[counter]);
            } catch (e) {
            }

            return;
        }

        Dcat.onPjaxComplete(() => {
            self._destroy(counter);
        });

        self.rendering = 1;

        $btn && $btn.buttonLoading();

        Dcat.NP.start();

        $.ajax({
            url: url,
            success: function (template) {
                self.rendering = 0;
                Dcat.NP.done();

                if ($btn) {
                    $btn.buttonLoading(false);

                    setTimeout(function () {
                        $btn.find('.waves-ripple').remove();
                    }, 50);
                }

                self._popup(template, counter);
            }
        });
    }

    _popup(template, counter) {
        let self = this,
            options = self.options;

        template = Dcat.assets.resolveHtml(template).render();

        let dialogOpts = {
            type: 1,
            area: (function (v) {
                    if (w.screen.width <= 800) {
                        return ['100%', '100%',];
                    }

                    return v;
                })(options.area),
            content: template,
            title: options.title,
            cancel: function () {
                if (options.forceRefresh) {
                    self._dialogs[counter] = self._idx[counter] = null;
                } else {
                    self._dialogs[counter].hide();
                    return false;
                }
            }
        };

        if (options.shown) {
            dialogOpts.success = function () {
                options.shown();
            };
        }

        if (options.hidden) {
            dialogOpts.end = function () {
                options.hidden();
            };
        }

        self._idx[counter] = self._dialog.open(dialogOpts);
        self._dialogs[counter] = w.$('#layui-layer' + self._idx[counter]);
    }

    _destroy(counter) {
        let dialogs = this._dialogs;

        this._dialog.close(this._idx[counter]);

        dialogs[counter] && dialogs[counter].remove();

        dialogs[counter] = null;
    }
}
