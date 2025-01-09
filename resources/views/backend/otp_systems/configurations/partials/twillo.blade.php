<div class="form-group row">
    <input type="hidden" name="types[]" value="TWILIO_SID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('TWILIO SID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="TWILIO_SID" value="{{ env('TWILIO_SID') }}"
            placeholder="TWILIO SID" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="TWILIO_AUTH_TOKEN">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('TWILIO AUTH TOKEN') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="TWILIO_AUTH_TOKEN"
            value="{{ env('TWILIO_AUTH_TOKEN') }}" placeholder="TWILIO AUTH TOKEN" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="VALID_TWILLO_NUMBER">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('VALID TWILIO NUMBER') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="VALID_TWILLO_NUMBER"
            value="{{ env('VALID_TWILLO_NUMBER') }}" placeholder="VALID TWILLO NUMBER">
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="TWILLO_TYPE">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('TWILIO TYPE') }}</label>
    </div>
    <div class="col-lg-6">
        <select class="form-control" name="TWILLO_TYPE">
        <option value="1" {{ env('TWILLO_TYPE') < 2 ? 'selected' : false }}>{{ translate('SMS') }}</option>
        <option value="2" {{ env('TWILLO_TYPE') > 1 ? 'selected' : false }}>{{ translate('WhatsApp') }}</option>
    </select>
    </div>
    
</div>

<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>

