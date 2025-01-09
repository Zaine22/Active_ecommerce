<div class="form-group row">
    <input type="hidden" name="types[]" value="MIMO_USERNAME">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('MIMO_USERNAME') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MIMO_USERNAME"
            value="{{ env('MIMO_USERNAME') }}" placeholder="MIMO_USERNAME" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="MIMO_PASSWORD">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('MIMO_PASSWORD') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MIMO_PASSWORD"
            value="{{ env('MIMO_PASSWORD') }}" placeholder="MIMO_PASSWORD" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="MIMO_SENDER_ID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('MIMO_SENDER_ID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MIMO_SENDER_ID"
            value="{{ env('MIMO_SENDER_ID') }}" placeholder="MIMO_SENDER_ID" required>
    </div>
</div>
<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>