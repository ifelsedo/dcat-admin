
@php
    $itemWidth = $itemWidth ?? 51; // 每个选项的基础宽度
    $gap = $gap ?? 4; // 选项之间的间距
    $padding = $padding ?? 30; // 下拉面板左右内边距总和
    $itemsPerRow = max((int) ($itemsPerRow ?? 1), 1);

    $dropdownWidth = ($itemsPerRow * $itemWidth) + (($itemsPerRow - 1) * $gap) + $padding;
    $dropdownWidth = max($dropdownWidth, 120);

    $selectedValue = is_array($value ?? null)
        ? (string) (reset($value) ?: '')
        : (string) ($value ?? '');
@endphp

@include('admin::filter.dropdown-selector-assets')


    <div class="input-group input-group-sm">
        <div class="input-group-prepend">
            <span class="input-group-text bg-white text-capitalize"><b>{!! $label !!}</b></span>
        </div>

        <div
            class="dropdown dropdown-selector-container dropdown-radio-container"
            data-dropdown-selector="radio"
            data-selector-type="radio"
            data-input-name="{{ $name }}"
            data-placeholder="选择"
            data-max-display="1"
            data-close-on-change="true"
        >
            <div
                id="dropdown-{{ $id }}"
                class="form-control dropdown-selector-toggle dropdown-radio-toggle"
                role="button"
                tabindex="0"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <button
                    type="button"
                    class="clear-all-btn dropdown-selector-clear dropdown-radio-clear"
                    title="清除当前选中项"
                    aria-label="清除当前选中项"
                >
                    <span aria-hidden="true">×</span>
                </button>

                <ul class="selected-content dropdown-selector-rendered dropdown-radio-selection__rendered">
                    @if($selectedValue !== '')
                        @foreach($options as $optionValue => $optionLabel)
                            @php
                                $optionStringValue = (string) $optionValue;
                            @endphp
                            @if($optionStringValue === $selectedValue)
                                <li class="tag-item dropdown-selector-choice dropdown-radio-selection__choice" data-value="{{ $optionStringValue }}">
                                    {{ $optionLabel }}
                                    <button
                                        type="button"
                                        class="remove-tag dropdown-selector-choice-remove dropdown-radio-selection__choice__remove"
                                        aria-label="移除 {{ $optionLabel }}"
                                    >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @else
                        <span class="placeholder-text dropdown-selector-placeholder dropdown-radio_placeholder">选择</span>
                    @endif
                </ul>
            </div>

            <ul
                class="dropdown-menu dropdown-menu-adaptive dropdown-selector-menu"
                style="width: {{ $dropdownWidth }}px;"
            >
                <li class="dropdown-selector-menu-item">
                    <div
                        class="dropdown-selector-options radio-options-container"
                        style="--dropdown-selector-option-width: {{ $itemWidth }}px; --dropdown-selector-gap: {{ $gap }}px;"
                    >
                        @foreach($options as $optionValue => $optionLabel)
                            @php
                                $optionStringValue = (string) $optionValue;
                            @endphp
                            <div class="dropdown-selector-option radio-option-item">
                                <label class="form-group mb-0">
                                    <div class="vs-radio-con vs-radio-primary">
                                        <input
                                            type="radio"
                                            name="radio-group-{{ $id }}"
                                            value="{{ $optionStringValue }}"
                                            id="option-{{ $id }}-{{ $loop->index }}"
                                            class="option-input option-radio Dcat_Admin_Widgets_Radio"
                                            data-label="{{ $optionLabel }}"
                                            {{ $optionStringValue === $selectedValue ? 'checked' : '' }}
                                        >
                                        <span class="vs-radio vs-radio-">
                                            <span class="vs-radio--border"></span>
                                            <span class="vs-radio--circle"></span>
                                        </span>
                                        <span class="dropdown-selector-option-label" title="{{ $optionLabel }}">{{ $optionLabel }}</span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </li>
            </ul>

            <div class="dropdown-selector-hidden-inputs">
                @if($selectedValue !== '')
                    <input type="hidden" name="{{ $name }}" value="{{ $selectedValue }}" class="real-input">
                @endif
            </div>
        </div>
    </div>


