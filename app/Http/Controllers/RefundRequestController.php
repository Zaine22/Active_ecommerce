<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\ClubPoint;
use App\Models\RefundRequest;
use App\Models\OrderDetail;
use App\Models\Shop;
use App\Models\Wallet;
use App\Models\User;
use App\Utility\EmailUtility;
use Artisan;
use Auth;

class RefundRequestController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_refund_requests'])->only('admin_index');
        $this->middleware(['permission:view_approved_refund_requests'])->only('paid_index');
        $this->middleware(['permission:view_rejected_refund_requests'])->only('rejected_index');
        $this->middleware(['permission:refund_request_configuration'])->only('refund_config');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Store Customer Refund Request
    public function request_store(Request $request, $id)
    {
        $user = auth()->user();
        $order_detail = OrderDetail::where('id', $id)->first();
        $refund = new RefundRequest;
        $refund->user_id = $user->id;
        $refund->order_id = $order_detail->order_id;
        $refund->order_detail_id = $order_detail->id;
        $refund->seller_id = $order_detail->seller_id;
        $refund->seller_approval = 0;
        $refund->reason = $request->reason;
        $refund->images = $request->images;
        $refund->admin_approval = 0;
        $refund->admin_seen = 0;
        $refund->refund_amount = $order_detail->price + $order_detail->tax;
        $refund->refund_status = 0;
        if ($refund->save()) {

            // Refund Request email to admin, Seller, customer
            $admin = get_admin();
            $emailIdentifiers = array('refund_request_email_to_admin');
            if($order_detail->order->user->email != null){
                array_push($emailIdentifiers, 'refund_request_email_to_customer');
            }
            if ($order_detail->order->seller_id != $admin->id) {
                array_push($emailIdentifiers, 'refund_request_email_to_seller');
            }

            EmailUtility::refundEmail($emailIdentifiers, $refund);
            
            flash( translate("Refund Request has been sent successfully") )->success();
            return redirect()->route('purchase_history.index');
        }
        else {
            flash( translate("Something went wrong") )->error();
            return back();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendor_index()
    {
        $refunds = RefundRequest::where('seller_id', Auth::user()->id)->latest()->paginate(10);
        return view('refund_request.frontend.recieved_refund_request.index', compact('refunds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_index()
    {
        $refunds = RefundRequest::where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('refund_request.frontend.refund_request.index', compact('refunds'));
    }

    //Set the Refund configuration
    public function refund_config()
    {
        return view('refund_request.config');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_time_update(Request $request)
    {
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->value;
            $business_settings->save();
        }
        Artisan::call('cache:clear');
        flash( translate("Refund Request sending time has been updated successfully") )->success();
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_sticker_update(Request $request)
    {
        $business_settings = BusinessSetting::where('type', $request->type)->first();
        if ($business_settings != null) {
            $business_settings->value = $request->logo;
            $business_settings->save();
        }
        else {
            $business_settings = new BusinessSetting;
            $business_settings->type = $request->type;
            $business_settings->value = $request->logo;
            $business_settings->save();
        }
        Artisan::call('cache:clear');
        flash( translate("Refund Sticker has been updated successfully"))->success();
        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_index()
    {
        $refunds = RefundRequest::where('refund_status', 0)->latest()->paginate(15);
        return view('refund_request.index', compact('refunds'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paid_index()
    {
        $refunds = RefundRequest::where('refund_status', 1)->latest()->paginate(15);
        return view('refund_request.paid_refund', compact('refunds'));
    }

    public function rejected_index()
    {
        $refunds = RefundRequest::where('refund_status', 2)->latest()->paginate(15);
        return view('refund_request.rejected_refund', compact('refunds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function request_approval_vendor(Request $request)
    {
        $authUser = auth()->user();
        $refund = RefundRequest::findOrFail($request->el);
        $refund->seller_approval = 1;

        if ($refund->save()) {
            // Refund Request Approval mail to admin and seller
            $emailIdentifiers = array('refund_accepted_by_seller_email_to_admin', 'refund_accepted_by_seller_email_to_seller');
            EmailUtility::refundEmail($emailIdentifiers, $refund);

            return 1;
        }
        else {
            return 0;
        }
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refund_pay(Request $request)
    {
        $refund = RefundRequest::findOrFail($request->refund_id);

        if ($refund->seller_approval == 1) {
            $seller = Shop::where('user_id', $refund->seller_id)->first();
            if ($seller != null) {
                $seller->admin_to_pay -= $refund->refund_amount;
            }
            $seller->save();
        }

        $refund_amount = $refund->refund_amount;

        // Club Point conversion check
        if (addon_is_activated('club_point')) {
            $club_point = ClubPoint::where('order_id', $refund->order_id)->first();
            if($club_point != null){
                $club_point_details = $club_point->club_point_details->where('product_id',$refund->orderDetail->product->id)->first();
                
                if($club_point->convert_status == 1 ){
                    $refund_amount -= $club_point_details->converted_amount;  
                }
                else{
                    $club_point_details->refunded = 1;
                    $club_point_details->save();
                }
            }
        }

        $wallet = new Wallet;
        $wallet->user_id = $refund->user_id;
        $wallet->amount = $refund_amount;
        $wallet->payment_method = 'Refund';
        $wallet->payment_details = 'Product Money Refund';
        $wallet->save();

        $user = User::findOrFail($refund->user_id);
        $user->balance += $refund_amount;
        $user->save();
        if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
            $refund->admin_approval = 1;
            $refund->refund_status = 1;
        }

        if ($refund->save()) {

            // Refund request approved email send to admin, seller and Customer
            $admin = get_admin();
            $order_detail =  $refund->orderDetail;
            $emailIdentifiers = array('refund_accepted_by_admin_email_to_admin');
            if($order_detail->order->user->email != null){
                array_push($emailIdentifiers, 'refund_request_accepted_email_to_customer');
            }
            if ($order_detail->order->seller_id != $admin->id) {
                array_push($emailIdentifiers, 'refund_accepted_by_admin_email_to_seller');
            }

            EmailUtility::refundEmail($emailIdentifiers, $refund);

            flash(translate('Refund has been sent successfully.'))->success();
        }
        else {
            flash(translate('Something went wrong.'))->error();
        }
        return back();
    }

    public function reject_refund_request(Request $request){
        $authUserType = auth()->user()->user_type;
        $refund = RefundRequest::findOrFail($request->refund_id);
        if ($authUserType == 'admin' ||  $authUserType == 'staff') {
            $refund->admin_approval = 2;
            $refund->refund_status  = 2;
            $refund->reject_reason  = $request->reject_reason;
        }
        else{
            $refund->seller_approval = 2;
            $refund->reject_reason  = $request->reject_reason;
        }
        
        if ($refund->save()) {
            // Refund request denied email send to admin, seller and Customer
            $admin = get_admin();
            $order_detail =  $refund->orderDetail;
            if ($authUserType == 'admin' ||  $authUserType == 'staff') {
                $emailIdentifiers = array('refund_denied_by_admin_email_to_admin');
                if($order_detail->order->user->email != null){
                    array_push($emailIdentifiers, 'refund_request_denied_email_to_customer');
                }
                if ($order_detail->order->seller_id != $admin->id) {
                    array_push($emailIdentifiers, 'refund_denied_by_admin_email_to_seller');
                }
            }
            else{
                $emailIdentifiers = array('refund_denied_by_seller_email_to_admin', 'refund_denied_by_seller_email_to_seller');
            }
            EmailUtility::refundEmail($emailIdentifiers, $refund);
            
            flash(translate('Refund request rejected successfully.'))->success();
            return back();
        }
        else {
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refund_request_send_page($id)
    {
        $order_detail = OrderDetail::findOrFail($id);
        if ($order_detail->product != null && $order_detail->product->refundable == 1) {
            return view('refund_request.frontend.refund_request.create', compact('order_detail'));
        }
        else {
            return back();
        }
    }

    /**
     * Show the form for view the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Shows the refund reason
    public function reason_view($id)
    {
        $user = auth()->user();
        $refund = RefundRequest::findOrFail($id);
        if ($user->user_type == 'admin' || $user->user_type == 'staff') {
            if ($refund->orderDetail != null) {
                $refund->admin_seen = 1;
                $refund->save();
                return view('refund_request.reason', compact('refund'));
            }
        }
        else {
            return view('refund_request.frontend.refund_request.reason', compact('refund'));
        }
    }

    public function reject_reason_view($id)
    {
        $refund = RefundRequest::findOrFail($id);
        return $refund->reject_reason;
    }

}
