<style>
    .quick-search-form .table-filter {
        position: relative;
    }
    .quick-search-clear {
        position: absolute;
        right: 14px;
        top: 50%;
        margin-top: -5px;
        color: #ccc;
        cursor: pointer;
        display: none;
        z-index: 10;
    }
    .quick-search-form input::-webkit-search-cancel-button {
        display: none;
    }
    ::-ms-clear,::-ms-reveal{display: none;}
</style>

<form pjax-container action="{!! $action !!}" class="input-no-border quick-search-form d-md-inline-block" style="display:none;margin-right: 16px">
    <div class="table-filter">
        <label style="width: {{ $width }}rem">
            <input
                    type="search"
                    class="form-control form-control-sm quick-search-input"
                    placeholder="{{ $placeholder }}"
                    name="{{ $key }}"
                    value="{{ $value }}"
                    auto="{{ $auto ? '1' : '0' }}"
            >
            <i class="quick-search-clear feather icon-x text-black-50 font-weight-bold"></i>
        </label>
    </div>
</form>
