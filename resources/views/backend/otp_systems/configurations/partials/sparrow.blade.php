<div class="form-group row">
    <input type="hidden" name="types[]" value="SPARROW_TOKEN">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SPARROW_TOKEN') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="SPARROW_TOKEN"
            value="{{ env('SPARROW_TOKEN') }}" placeholder="SPARROW_TOKEN" required>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="MESSGAE_FROM">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('MESSGAE_FROM') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="MESSGAE_FROM"
            value="{{ env('MESSGAE_FROM') }}" placeholder="MESSGAE_FROM" required>
    </div>
</div>
<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>