
@once
<style>
.dropdown-selector-placeholder {
    color: #999;
    font-size: .7rem;
    line-height: 30px !important;
    white-space: nowrap;
}

.dropdown-selector-container {
    position: relative;
    display: block;
    flex: 1 1 0%;
    width: 1%;
    min-width: 0;
    box-sizing: border-box;
    margin: 0;
}

.dropdown-selector-toggle {
    min-height: 30px !important;
    padding: 0 28px 0 2px !important;
    font-size: .7rem;
    line-height: 14px;
    background-color: #fff;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    min-width: 0;
    display: flex;
    align-items: center;
    text-align: left;
    position: relative;
    user-select: none;
}

.input-group-sm .dropdown-selector-toggle {
    min-height: 30px !important;
    padding: 0 28px 0 2px !important;
    font-size: .7rem;
    line-height: 14px;
}

.dropdown-selector-clear {
    cursor: pointer;
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    padding: 0;
    background-color: transparent;
    border: none;
    font-size: 1em;
    font-weight: bold;
    line-height: 1;
    z-index: 2;
}

.dropdown-selector-rendered {
    padding: 0 .4rem !important;
    list-style: none;
    margin: -3px 0 -.35rem;
    overflow: hidden;
    white-space: nowrap;
    line-height: 30px !important;
    height: auto;
    flex: 1 1 auto;
    min-width: 0;
}

.dropdown-selector-choice {
    border-radius: 4px;
    display: inline-block;
    margin-left: 5px;
    margin-top: 5px;
    padding: 2px 5px !important;
    border: 0 !important;
    font-size: 90%;
    background-color: #586cb1 !important;
    color: #fff;
    line-height: 14px;
}

.dropdown-selector-choice-remove {
    background-color: transparent;
    border: none;
    border-top-left-radius: 4px;
    border-bottom-left-radius: 4px;
    cursor: pointer;
    font-size: 1em;
    font-weight: bold;
    padding: 0 4px;
    color: #fff !important;
    border-right: 0 !important;
    float: right;
    margin-left: 5px;
    margin-right: -2px;
}

.dropdown-selector-menu.dropdown-menu-right {
    right: 0;
    left: auto;
}

.dropdown-selector-menu {
    position: absolute;
    transform: none;
    overflow-x: hidden;
    padding: 15px;
    margin-top: 10px;
    z-index: 1050;
    display: none;
    flex-direction: column;
    font-size: 1rem;
    line-height: 1.45;
    color: #414750;
    overflow: visible;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, .08);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(31, 35, 41, .12);
    background-clip: padding-box;
}

.dropdown-selector-menu::before {
    content: '';
    position: absolute;
    top: -8px;
    left: 20px;
    width: 16px;
    height: 16px;
    background: #fff;
    border-top: 1px solid rgba(0, 0, 0, .08);
    border-left: 1px solid rgba(0, 0, 0, .08);
    transform: rotate(45deg);
    box-shadow: -3px -3px 10px rgba(31, 35, 41, .08);
    z-index: 0;
}

.dropdown-selector-menu.dropdown-menu-right::before {
    left: auto;
    right: 20px;
}

.dropdown-selector-menu-item {
    margin: 0;
    padding: 0;
    width: 100%;
    position: relative;
    z-index: 1;
}

.dropdown-selector-options {
    display: flex;
    flex-wrap: wrap;
    gap: var(--dropdown-selector-gap, 4px);
    padding: 0;
    margin: 0;
    align-items: flex-start;
    width: 100%;
}

.dropdown-selector-option {
    width: var(--dropdown-selector-option-width, 51px);
    flex: 0 0 auto;
    margin: 0;
    padding: 2px 3px;
    border-radius: 4px;
    transition: background-color .2s;
    display: flex;
    align-items: center;
}

.dropdown-selector-option:hover {
    background-color: #f8f9fa;
}

.dropdown-selector-option .form-group {
    margin-bottom: 0 !important;
    display: flex;
    align-items: center;
}

.dropdown-selector-option .vs-checkbox-con,
.dropdown-selector-option .vs-radio-con {
    font-size: .9rem !important;
    line-height: 1.2 !important;
    color: #414750;
    display: flex !important;
    align-items: center !important;
    white-space: nowrap;
    margin: 0;
    padding: 0;
}

.dropdown-selector-option .vs-checkbox,
.dropdown-selector-option .vs-radio {
    margin-right: 6px;
    flex-shrink: 0;
}

.dropdown-selector-option .dropdown-selector-option-label {
    font-size: .9rem !important;
    line-height: 1.2 !important;
    color: #414750;
    margin-left: 0 !important;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100px;
    display: inline-block;
    vertical-align: middle;
}
</style>

<script>
(function ($) {
    if (!$ || window.dropdownSelectorAssetsInitialized) {
        return;
    }

    window.dropdownSelectorAssetsInitialized = true;

    function escapeHtml(text) {
        return $('<div>').text(text == null ? '' : String(text)).html();
    }

    function getContainer(element) {
        return $(element).closest('[data-dropdown-selector]');
    }

    function getToggle(container) {
        return container.find('.dropdown-selector-toggle').first();
    }

    function getMenu(container) {
        return container.find('.dropdown-selector-menu').first();
    }

    function getSelectedContent(container) {
        return container.find('.dropdown-selector-rendered').first();
    }

    function getPlaceholder(container) {
        return getSelectedContent(container).find('.placeholder-text').first();
    }

    function getClearButton(container) {
        return container.find('.clear-all-btn').first();
    }

    function getInputGroup(container) {
        return container.closest('.input-group');
    }

    function markInitialized(container) {
        container.attr('data-dropdown-selector-initialized', '1');
    }

    function isInitialized(container) {
        return container.attr('data-dropdown-selector-initialized') === '1';
    }

    function getInputName(container) {
        return container.data('input-name') || '';
    }

    function getSelectorType(container) {
        return container.data('selector-type') || container.data('dropdown-selector') || 'checkbox';
    }

    function getPlaceholderText(container) {
        return container.data('placeholder') || '选择';
    }

    function getMaxDisplay(container) {
        var value = parseInt(container.data('max-display'), 10);
        return isNaN(value) ? 2 : value;
    }

    function getDisplayMode(container) {
        return container.data('display-mode') || 'auto';
    }

    function shouldCloseOnChange(container) {
        var value = container.data('close-on-change');

        return value === true || value === 1 || value === '1' || value === 'true';
    }

    function getCheckedOptions(container) {
        return container.find('.option-input:checked');
    }

    function getToggleContentWidth(container) {
        var selectedContent = getSelectedContent(container);

        if (!selectedContent.length) {
            return 0;
        }

        return Math.max(selectedContent.innerWidth(), 0);
    }

    function createMeasurementNode(selectedContent) {
        return $('<ul class="selected-content dropdown-selector-rendered"></ul>').css({
            position: 'absolute',
            visibility: 'hidden',
            left: '-99999px',
            top: '-99999px',
            width: 'auto',
            maxWidth: 'none',
            display: 'inline-block',
            zIndex: -1
        }).appendTo(document.body);
    }

    function measureRenderedWidth(container, html) {
        var selectedContent = getSelectedContent(container);
        var measurementNode;
        var width;

        if (!selectedContent.length) {
            return 0;
        }

        measurementNode = createMeasurementNode(selectedContent);
        measurementNode.html(html);

        width = measurementNode.outerWidth();

        measurementNode.remove();

        return width;
    }

    function canRenderWithinWidth(container, html) {
        return measureRenderedWidth(container, html) <= getToggleContentWidth(container);
    }

    function buildChoiceHtml(value, label) {
        return '' +
            '<li class="tag-item dropdown-selector-choice" data-value="' + escapeHtml(value) + '">' +
                escapeHtml(label) +
                '<button type="button" class="remove-tag dropdown-selector-choice-remove" aria-label="移除已选项">' +
                    '<span aria-hidden="true">×</span>' +
                '</button>' +
            '</li>';
    }

    function buildCountHtml(count) {
        return '' +
            '<li class="tag-item dropdown-selector-choice">' +
                count + '个已选中' +
            '</li>';
    }

    function buildMoreHtml(count) {
        return '' +
            '<li class="tag-item dropdown-selector-choice">' +
                '+' + count +
            '</li>';
    }

    function renderChoicesHtml(choices) {
        return $.map(choices, function (choice) {
            return buildChoiceHtml(choice.value, choice.label);
        }).join('');
    }

    function getCheckboxDisplayState(container, checkedOptions) {
        var visibleChoices = [];
        var allChoices = [];
        var hiddenCount = 0;
        var i;
        var option;
        var allChoicesHtml;
        var partialChoicesHtml;

        if (checkedOptions.length === 0) {
            return {
                mode: 'count'
            };
        }

        if (checkedOptions.length === 1) {
            option = $(checkedOptions[0]);

            return {
                mode: 'all',
                visibleChoices: [{
                    value: option.val(),
                    label: option.data('label')
                }],
                hiddenCount: 0
            };
        }

        for (i = 0; i < checkedOptions.length; i++) {
            option = $(checkedOptions[i]);
            allChoices.push({
                value: option.val(),
                label: option.data('label')
            });
        }

        allChoicesHtml = renderChoicesHtml(allChoices);

        if (canRenderWithinWidth(container, allChoicesHtml)) {
            return {
                mode: 'all',
                visibleChoices: allChoices,
                hiddenCount: 0
            };
        }

        for (i = allChoices.length - 1; i >= 1; i--) {
            visibleChoices = allChoices.slice(0, i);
            hiddenCount = allChoices.length - visibleChoices.length;
            partialChoicesHtml = renderChoicesHtml(visibleChoices) + buildMoreHtml(hiddenCount);

            if (canRenderWithinWidth(container, partialChoicesHtml)) {
                return {
                    mode: 'partial',
                    visibleChoices: visibleChoices,
                    hiddenCount: hiddenCount
                };
            }
        }

        return {
            mode: 'count',
            hiddenCount: allChoices.length
        };
    }

    function renderPlaceholder(container) {
        var selectedContent = getSelectedContent(container);
        var placeholder = getPlaceholder(container);

        if (placeholder.length === 0) {
            selectedContent.append(
                '<span class="placeholder-text dropdown-selector-placeholder">' +
                escapeHtml(getPlaceholderText(container)) +
                '</span>'
            );
        } else {
            placeholder.text(getPlaceholderText(container)).show();
        }
    }

    function syncHiddenInputs(container) {
        var inputGroup = getInputGroup(container);
        var inputName = getInputName(container);
        var selectorType = getSelectorType(container);
        var checkedOptions = getCheckedOptions(container);

        inputGroup.find('.real-input').remove();

        if (!inputName) {
            return;
        }

        if (selectorType === 'radio') {
            if (checkedOptions.length > 0) {
                $('<input>', {
                    type: 'hidden',
                    name: inputName,
                    value: checkedOptions.first().val(),
                    'class': 'real-input'
                }).appendTo(inputGroup);
            }
            return;
        }

        checkedOptions.each(function () {
            $('<input>', {
                type: 'hidden',
                name: inputName + '[]',
                value: $(this).val(),
                'class': 'real-input'
            }).appendTo(inputGroup);
        });
    }

    function updateClearButton(container) {
        var clearButton = getClearButton(container);
        clearButton.toggle(getCheckedOptions(container).length > 0);
    }

    function updateTags(container) {
        var checkedOptions = getCheckedOptions(container);
        var selectedContent = getSelectedContent(container);
        var placeholder = getPlaceholder(container);
        var maxDisplay = getMaxDisplay(container);
        var selectorType = getSelectorType(container);
        var displayMode = getDisplayMode(container);
        var shouldShowCountOnly = false;
        var checkboxDisplayState = null;

        selectedContent.find('.tag-item').remove();

        if (checkedOptions.length === 0) {
            renderPlaceholder(container);
            syncHiddenInputs(container);
            updateClearButton(container);
            return;
        }

        if (placeholder.length > 0) {
            placeholder.hide();
        }

        if (selectorType === 'checkbox') {
            if (displayMode === 'count') {
                shouldShowCountOnly = true;
            } else if (displayMode === 'auto') {
                checkboxDisplayState = getCheckboxDisplayState(container, checkedOptions);

                if (checkboxDisplayState.mode === 'count') {
                    shouldShowCountOnly = true;
                } else if (checkboxDisplayState.mode === 'partial') {
                    $.each(checkboxDisplayState.visibleChoices, function (_, choice) {
                        selectedContent.append(buildChoiceHtml(choice.value, choice.label));
                    });

                    selectedContent.append(buildMoreHtml(checkboxDisplayState.hiddenCount));
                    syncHiddenInputs(container);
                    updateClearButton(container);
                    return;
                }
            } else if (checkedOptions.length > maxDisplay) {
                shouldShowCountOnly = true;
            }
        }

        if (shouldShowCountOnly) {
            selectedContent.append(buildCountHtml(checkedOptions.length));
            syncHiddenInputs(container);
            updateClearButton(container);
            return;
        }

        checkedOptions.each(function () {
            var option = $(this);
            selectedContent.append(buildChoiceHtml(option.val(), option.data('label')));
        });

        syncHiddenInputs(container);
        updateClearButton(container);
    }

    function closeDropdown(container) {
        var menu = getMenu(container);
        var toggle = getToggle(container);

        menu.css('display', 'none');
        toggle.attr('aria-expanded', 'false');
    }

    function openDropdown(container) {
        var menu = getMenu(container);
        var toggle = getToggle(container);

        menu.css('display', 'flex');
        adjustDropdownPosition(container);
        toggle.attr('aria-expanded', 'true');
    }

    function adjustDropdownPosition(container) {
        var toggle = getToggle(container);
        var menu = getMenu(container);

        if (!toggle.length || !menu.length) {
            return;
        }

        var windowWidth = $(window).width();
        var toggleOffset = toggle.offset();
        var toggleWidth = toggle.outerWidth();
        var menuWidth = menu.outerWidth();

        if (!toggleOffset) {
            return;
        }

        var rightSpace = windowWidth - (toggleOffset.left + toggleWidth);
        var leftSpace = toggleOffset.left + toggleWidth;

        menu.removeClass('dropdown-menu-right').css({
            left: '',
            right: ''
        });

        if (rightSpace < menuWidth && leftSpace >= menuWidth) {
            menu.addClass('dropdown-menu-right');
        } else if (rightSpace < menuWidth && leftSpace < menuWidth && leftSpace > rightSpace) {
            menu.addClass('dropdown-menu-right');
        }
    }

    $(document).on('click', '.dropdown-selector-toggle', function (e) {
        if ($(e.target).closest('.clear-all-btn, .remove-tag').length) {
            return;
        }

        e.preventDefault();
        e.stopPropagation();

        var container = getContainer(this);
        var menu = getMenu(container);
        var toggle = getToggle(container);

        $('.dropdown-selector-menu').not(menu).hide();
        $('.dropdown-selector-toggle').not(toggle).attr('aria-expanded', 'false');

        if (menu.is(':visible')) {
            closeDropdown(container);
        } else {
            openDropdown(container);
        }
    });

    $(document).on('keydown', '.dropdown-selector-toggle', function (e) {
        var container = getContainer(this);

        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).trigger('click');
        } else if (e.key === 'Escape') {
            e.preventDefault();
            closeDropdown(container);
        }
    });

    $(document).on('click', '.dropdown-selector-menu', function (e) {
        e.stopPropagation();
    });

    $(document).on('click', '.clear-all-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var container = getContainer(this);
        container.find('.option-input').prop('checked', false);

        updateTags(container);
    });

    $(document).on('click', '.dropdown-selector-rendered .remove-tag', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var container = getContainer(this);
        var value = $(this).closest('.tag-item').data('value');

        container.find('.option-input[value="' + value + '"]').prop('checked', false);

        updateTags(container);
    });

    $(document).on('change', '[data-dropdown-selector] .option-input', function () {
        var container = getContainer(this);

        updateTags(container);

        if (shouldCloseOnChange(container)) {
            closeDropdown(container);
        }
    });

    $(document).on('click', function (e) {
        var target = $(e.target);

        if (target.closest('[data-dropdown-selector]').length === 0) {
            $('.dropdown-selector-menu').css('display', 'none');
            $('.dropdown-selector-toggle').attr('aria-expanded', 'false');
        }
    });

    $(window).on('resize', function () {
        $('[data-dropdown-selector]').each(function () {
            var container = $(this);

            updateTags(container);

            if (getMenu(container).is(':visible')) {
                adjustDropdownPosition(container);
            }
        });
    });

    function initializeDropdownSelectors(scope) {
        var root = scope ? $(scope) : $(document);

        root.find('[data-dropdown-selector]').each(function () {
            var container = $(this);

            if (isInitialized(container)) {
                closeDropdown(container);
                return;
            }

            updateTags(container);
            closeDropdown(container);
            markInitialized(container);
        });
    }

    $(function () {
        initializeDropdownSelectors(document);
    });

    $(document).on('pjax:success pjax:complete', function (e) {
        initializeDropdownSelectors(e.target);
    });
})(window.jQuery);
</script>
@endonce
