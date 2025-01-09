<!--<div class="form-group row">-->
<!--    <input type="hidden" name="types[]" value="NEXMO_KEY">-->
<!--    <div class="col-lg-3">-->
<!--        <label class="col-from-label">{{ translate('NEXMO KEY') }}</label>-->
<!--    </div>-->
<!--    <div class="col-lg-6">-->
<!--        <input type="text" class="form-control" name="NEXMO_KEY" value="{{ env('NEXMO_KEY') }}"-->
<!--            placeholder="NEXMO KEY" required>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group row">-->
<!--    <input type="hidden" name="types[]" value="NEXMO_SECRET">-->
<!--    <div class="col-lg-3">-->
<!--        <label class="col-from-label">{{ translate('NEXMO SECRET') }}</label>-->
<!--    </div>-->
<!--    <div class="col-lg-6">-->
<!--        <input type="text" class="form-control" name="NEXMO_SECRET"-->
<!--            value="{{ env('NEXMO_SECRET') }}" placeholder="NEXMO SECRET" required>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group row">-->
<!--    <input type="hidden" name="types[]" value="NEXMO_SENDER_ID">-->
<!--    <div class="col-lg-3">-->
<!--        <label class="col-from-label">{{translate('NEXMO SENDER ID')}}</label>-->
<!--    </div>-->
<!--    <div class="col-lg-6">-->
<!--        <input type="text" class="form-control" name="NEXMO_SENDER_ID" value="{{  env('NEXMO_SENDER_ID') }}" placeholder="NEXMO SENDER ID" required>-->
<!--        <small>-->
<!--            {{translate('Please check this URL for')}}-->
<!--            <a href="https://developer.vonage.com/en/messaging/sms/guides/custom-sender-id?source=messaging">Sender Identity</a> -->
<!--            {{translate('before setting the sender ID')}}-->
<!--        </small>-->
<!--    </div>-->
<!--</div>-->
<!--<div class="form-group mb-0 text-right">-->
<!--    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>-->
<!--</div>-->
<div class="form-group row">
    <input type="hidden" name="types[]" value="NEXMO_KEY">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SMSPOH API KEY') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="NEXMO_KEY"
            value="{{ env('NEXMO_KEY') }}" placeholder="SMSPOH API KEY" required>
    </div>
</div>

<div class="form-group row">
    <input type="hidden" name="types[]" value="NEXMO_SENDER_ID">
    <div class="col-lg-3">
        <label class="col-from-label">{{ translate('SMSPOH SENDER ID') }}</label>
    </div>
    <div class="col-lg-6">
        <input type="text" class="form-control" name="NEXMO_SENDER_ID"
            value="{{ env('NEXMO_SENDER_ID') }}" placeholder="SMSPOH SENDER ID" required>
        <small>
            {{ translate('Please ensure the Sender ID is registered with SMSPoh before setting.') }}
        </small>
    </div>
</div>

<!--<div class="form-group row">-->
<!--    <input type="hidden" name="types[]" value="SMSPOH_APP_NAME">-->
<!--    <div class="col-lg-3">-->
<!--        <label class="col-from-label">{{ translate('SMSPOH APP NAME') }}</label>-->
<!--    </div>-->
<!--    <div class="col-lg-6">-->
<!--        <input type="text" class="form-control" name="SMSPOH_APP_NAME"-->
<!--            value="{{ env('SMSPOH_APP_NAME', 'YourAppName') }}" placeholder="SMSPOH APP NAME">-->
<!--    </div>-->
<!--</div>-->

<!--<div class="form-group row">-->
<!--    <input type="hidden" name="types[]" value="SMSPOH_APP_VERSION">-->
<!--    <div class="col-lg-3">-->
<!--        <label class="col-from-label">{{ translate('SMSPOH APP VERSION') }}</label>-->
<!--    </div>-->
<!--    <div class="col-lg-6">-->
<!--        <input type="text" class="form-control" name="SMSPOH_APP_VERSION"-->
<!--            value="{{ env('SMSPOH_APP_VERSION', '1.0.0') }}" placeholder="SMSPOH APP VERSION">-->
<!--    </div>-->
<!--</div>-->

<div class="form-group mb-0 text-right">
    <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
</div>