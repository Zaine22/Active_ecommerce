<div class="form-group row">
    <input type="hidden" name="types[]" value="MIM_USER_NAME">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('User Name') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MIM_USER_NAME"
            value="{{ env('MIM_USER_NAME') }}" placeholder="{{ translate('User Name') }}" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="MIM_API_KEY">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('API Key') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MIM_API_KEY"
            value="{{ env('MIM_API_KEY') }}" placeholder="{{ translate('MIM API Key') }}" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="MIM_SENDER_ID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('Sender ID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MIM_SENDER_ID"
            value="{{ env('MIM_SENDER_ID') }}" placeholder="{{ translate('MIM Sender ID') }}" required>
    </div>
</div>

<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>