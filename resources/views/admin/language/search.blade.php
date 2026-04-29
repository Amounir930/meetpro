    <form>
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Code') }}</label>
                    <input type="text" value="{{ $filters['code'] ? $filters['code'] : '' }}" name="code"
                        class="form-control" placeholder="{{ __('Code') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Name') }}</label>
                    <input type="text" name="name" value="{{ $filters['name'] ? $filters['name'] : '' }}"
                        class="form-control" placeholder="{{ __('Name') }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Direction') }}</label>
                    <select name="direction" class="form-select" aria-label="Status"
                        placeholder="{{ __('Select Option') }}">
                        <option value="" selected>{{ __('Select Option') }}</option>
                        <option value="ltr" @selected($filters['direction'] == 'ltr')>{{ __('LTR (Left to Right)') }}</option>
                        <option value="rtl" @selected($filters['direction'] == 'rtl')>{{ __('RTL (Right to Left)') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Status') }}</label>
                    <select name="status" class="form-select" aria-label="Status"
                        placeholder="{{ __('Select Option') }}">
                        <option value="" selected>{{ __('Select Option') }}</option>
                        <option value="active" @selected($status == 'active')>{{ __('Active') }}</option>
                        <option value="inactive" @selected($status == 'inactive')>{{ __('Inactive') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-end mt-4 gap-1">
                    <a href="{{ route('admin.language') }}"><button type="submit"
                            class="btn btn-primary">{{ __('Search') }}</button></a>
                    <a href="{{ route('admin.language') }}"><button type="button"
                            class="btn bg-danger text-light">{{ __('Reset') }}</button></a>
                </div>
            </div>
        </div>
    </form>
