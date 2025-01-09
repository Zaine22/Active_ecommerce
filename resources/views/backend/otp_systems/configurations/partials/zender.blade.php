<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_SITEURL">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_SITEURL') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="ZENDER_SITEURL"
            value="{{ env('ZENDER_SITEURL') }}" placeholder="https://yourzendersite.com"
            required>
        <small>The site url of your Zender. Do not add ending slash.</small>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_APIKEY">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_APIKEY') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="ZENDER_APIKEY"
            value="{{ env('ZENDER_APIKEY') }}" placeholder="ZENDER_APIKEY" required>
        <small>Your Zender API key. Please make sure that it is correct and required permissions are
            granted: sms_send, wa_send</small>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_SERVICE">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_SERVICE') }}</label>
    </div>
    <div class="col-lg-6">
        <select class="form-control" name="ZENDER_SERVICE">
            <option value="1" {{ env('ZENDER_SERVICE') < 2 ? 'selected' : false }}>SMS
            </option>
            <option value="2" {{ env('ZENDER_SERVICE') > 1 ? 'selected' : false }}>WhatsApp
            </option>
        </select>
        <small>Select the sending service. Please make sure that the API key has the following
            permissions: sms_send, wa_send</small>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_WHATSAPP">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_WHATSAPP') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="ZENDER_WHATSAPP"
            value="{{ env('ZENDER_WHATSAPP') }}" placeholder="ZENDER_WHATSAPP">
        <small>For WhatsApp service only. WhatsApp account ID you want to use for sending.</small>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_DEVICE">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_DEVICE') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="ZENDER_DEVICE"
            value="{{ env('ZENDER_DEVICE') }}" placeholder="ZENDER_DEVICE">
        <small>For SMS service only. Linked device unique ID. Please only enter this field if you
            are sending using one of your devices.</small>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_GATEWAY">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_GATEWAY') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="ZENDER_GATEWAY"
            value="{{ env('ZENDER_GATEWAY') }}" placeholder="ZENDER_GATEWAY">
        <small>For SMS service only. Partner device unique ID or gateway ID. Please only enter this
            field if you are sending using a partner device or third party gateway.</small>
    </div>
</div>
<div class="form-group row">
    <input type="hidden" name="types[]" value="ZENDER_SIM">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('ZENDER_SIM') }}</label>
    </div>
    <div class="col-lg-6">
        <select class="form-control" name="ZENDER_SIM">
            <option value="1" {{ env('ZENDER_SIM') < 2 ? 'selected' : false }}>SIM 1</option>
            <option value="2" {{ env('ZENDER_SIM') > 1 ? 'selected' : false }}>SIM 2</option>
        </select>
        <small>For SMS service only. Select the sim slot you want to use for sending the messages.
            Please only enter this field if you are sending using your device. This is ignored for
            partner devices and third party gateways.</small>
    </div>
</div>
<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>