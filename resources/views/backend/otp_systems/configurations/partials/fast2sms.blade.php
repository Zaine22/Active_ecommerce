<div class="form-group row">
    <input type="hidden" name="types[]" value="AUTH_KEY">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('AUTH KEY') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="AUTH_KEY"
            value="{{ env('AUTH_KEY') }}" placeholder="AUTH KEY" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ENTITY_ID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ENTITY ID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="ENTITY_ID"
            value="{{ env('ENTITY_ID') }}" placeholder="{{ translate('Entity ID') }}">
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ROUTE">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ROUTE') }}</label>
    </div>
    <div class="col-lg-6">
        <select class="form-control aiz-selectpicker" name="ROUTE" required>
            <option value="dlt_manual" @if (env('ROUTE') == 'dlt_manual') selected @endif>
                {{ translate('DLT Manual') }}</option>
            <option value="p" @if (env('ROUTE') == 'p') selected @endif>
                {{ translate('Promotional Use') }}</option>
            <option value="t" @if (env('ROUTE') == 't') selected @endif>
                {{ translate('Transactional Use') }}</option>
        </select>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="LANGUAGE">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('LANGUAGE') }}</label>
    </div>
    <div class="col-lg-6">
        <select class="form-control aiz-selectpicker" name="LANGUAGE" required>
            <option value="english" @if (env('LANGUAGE') == 'english') selected @endif>English
            </option>
            <option value="unicode" @if (env('LANGUAGE') == 'unicode') selected @endif>Unicode
            </option>
        </select>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="SENDER_ID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SENDER ID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="SENDER_ID"
            value="{{ env('SENDER_ID') }}" placeholder="6 digit SENDER ID">
    </div>
</div>
<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>
           