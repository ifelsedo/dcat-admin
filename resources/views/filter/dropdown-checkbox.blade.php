
@php
    $itemWidth = $itemWidth ?? 51; // 每个选项的基础宽度
    $gap = $gap ?? 4; // 选项之间的间距
    $padding = $padding ?? 30; // 下拉面板左右内边距总和
    $itemsPerRow = max((int) ($itemsPerRow ?? 1), 1);
    $maxDisplay = max((int) ($maxDisplay ?? 2), 1);
    $displayMode = $displayMode ?? 'auto';

    $dropdownWidth = ($itemsPerRow * $itemWidth) + (($itemsPerRow - 1) * $gap) + $padding;
    $dropdownWidth = max($dropdownWidth, 120);

    $selectedValues = array_map('strval', (array) ($value ?? []));
@endphp

@include('admin::filter.dropdown-selector-assets')


    <div class="input-group input-group-sm">
        <div class="input-group-prepend">
            <span class="input-group-text bg-white text-capitalize"><b>{!! $label !!}</b></span>
        </div>

        <div
            class="dropdown dropdown-selector-container dropdown-checkbox-container"
            data-dropdown-selector
            data-selector-type="checkbox"
            data-input-name="{{ $name }}"
            data-placeholder="选择"
            data-max-display="{{ $maxDisplay }}"
            data-display-mode="{{ $displayMode }}"
        >
            <div
                id="dropdown-{{ $id }}"
                class="form-control dropdown-selector-toggle dropdown-checkbox-selection--multiple"
                role="button"
                tabindex="0"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <button
                    type="button"
                    class="clear-all-btn dropdown-selector-clear dropdown-checkbox-selection__choice__clear"
                    title="清除所有选中项"
                    aria-label="清除所有选中项"
                >
                    <span aria-hidden="true">×</span>
                </button>

                <ul class="selected-content dropdown-selector-rendered dropdown-checkbox-selection__rendered">
                    @if(count($selectedValues) > 0)
                        @if(count($selectedValues) <= $maxDisplay)
                            @foreach($options as $optionValue => $optionLabel)
                                @php
                                    $optionStringValue = (string) $optionValue;
                                @endphp
                                @if(in_array($optionStringValue, $selectedValues, true))
                                    <li class="tag-item dropdown-selector-choice dropdown-checkbox-selection__choice" data-value="{{ $optionStringValue }}">
                                        {{ $optionLabel }}
                                        <button
                                            type="button"
                                            class="remove-tag dropdown-selector-choice-remove dropdown-checkbox-selection__choice__remove"
                                            aria-label="移除 {{ $optionLabel }}"
                                        >
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="tag-item dropdown-selector-choice dropdown-checkbox-selection__choice">
                                {{ count($selectedValues) }}个已选中
                            </li>
                        @endif
                    @else
                        <span class="placeholder-text dropdown-selector-placeholder dropdown-checkbox_placeholder">选择</span>
                    @endif
                </ul>
            </div>

            <ul
                class="dropdown-menu dropdown-menu-adaptive dropdown-selector-menu"
                style="width: {{ $dropdownWidth }}px;"
            >
                <li class="dropdown-selector-menu-item">
                    <div
                        class="dropdown-selector-options checkbox-options-container"
                        style="--dropdown-selector-option-width: {{ $itemWidth }}px; --dropdown-selector-gap: {{ $gap }}px;"
                    >
                        @foreach($options as $optionValue => $optionLabel)
                            @php
                                $optionStringValue = (string) $optionValue;
                            @endphp
                            <div class="dropdown-selector-option checkbox-option-item">
                                <label class="form-group mb-0">
                                    <div class="vs-checkbox-con vs-checkbox-primary checkbox-grid">
                                        <input
                                            type="checkbox"
                                            value="{{ $optionStringValue }}"
                                            id="option-{{ $id }}-{{ $loop->index }}"
                                            class="option-checkbox option-input dropdown-selector-input"
                                            data-label="{{ $optionLabel }}"
                                            {{ in_array($optionStringValue, $selectedValues, true) ? 'checked' : '' }}
                                        >
                                        <span class="vs-checkbox"><span class="vs-checkbox--check"><i class="vs-icon feather icon-check"></i></span></span>
                                        <span class="dropdown-selector-option-label" title="{{ $optionLabel }}">{{ $optionLabel }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div>

