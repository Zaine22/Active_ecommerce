<div class="form-group row">
    <input type="hidden" name="types[]" value="SSL_SMS_API_TOKEN">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SSL SMS API TOKEN') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="SSL_SMS_API_TOKEN"
            value="{{ env('SSL_SMS_API_TOKEN') }}" placeholder="SSL SMS API TOKEN" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="SSL_SMS_SID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SSL SMS SID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="SSL_SMS_SID"
            value="{{ env('SSL_SMS_SID') }}" placeholder="SSL SMS SID" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="SSL_SMS_URL">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SSL SMS URL') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="SSL_SMS_URL"
            value="{{ env('SSL_SMS_URL') }}" placeholder="SSL SMS URL">
    </div>
</div>
<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>