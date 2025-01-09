<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Http\Resources\PosProductCollection;
use App\Models\Cart;
use App\Utility\FontUtility;
use App\Utility\PosUtility;
use Session;
use Mpdf\Mpdf;

class PosController extends Controller
{
    public function index()
    {
        $customers = User::where('user_type', 'customer')->where('email_verified_at', '!=', null)->orderBy('created_at', 'desc')->get();
        if (get_setting('pos_activation_for_seller') == 1) {
            return view('seller.pos.index', compact('customers'));
        }
        else {
            flash(translate('POS is disable for Sellers!!!'))->error();
            return back();
        }
    }

    public function search(Request $request)
    {
        $products = PosUtility::product_search($request->only('category', 'brand', 'keyword'));

        $stocks = new PosProductCollection($products);
        $stocks->appends(['keyword' =>  $request->keyword, 'category' => $request->category, 'brand' => $request->brand]);
        return $stocks;
    }

    // Add product To cart
    public function addToCart(Request $request)
    {   
        $stockId    = $request->stock_id;
        $userID     = Session::get('pos.user_id');
        $temUserId  = Session::get('pos.temp_user_id');
        if (!$temUserId && !$userID) {
            $temUserId = bin2hex(random_bytes(10));
            Session::put('pos.temp_user_id', $temUserId);
        }
        $response = PosUtility::addToCart($stockId, $userID, $temUserId);
        
        return array(
            'success' => $response['success'],
            'message' => $response['message'],
            'view' => view('backend.pos.cart')->render()
        );
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = Cart::find($request->cartId);
        $response = PosUtility::updateCartItemQuantity($cart, $request->only(['cartId', 'quantity']));

        return array('success' => $response['success'], 'message' => $response['message'], 'view' => view('backend.pos.cart')->render());
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        Cart::where('id', $request->id)->delete();
        return view('backend.pos.cart');
    }

    //Shipping Address for seller
    public function getShippingAddress(Request $request)
    {   
        Session::forget('pos.shipping_info');
        $user_id = $request->id;
        return ($user_id == '') ? view('seller.pos.guest_shipping_address') : view('seller.pos.shipping_address', compact('user_id'));
    }

    public function set_shipping_address(Request $request)
    {
        $data = PosUtility::get_shipping_address($request);

        $shipping_info = $data;
        $request->session()->put('pos.shipping_info', $shipping_info);
    }

    // Update user Cart data when user is changed 
    public function updateSessionUserCartData(Request $request){
        PosUtility::updateCartOnUserChange($request->only(['userId']));
        return view('backend.pos.cart');
    }

    //set Discount
    public function setDiscount(Request $request){
        if($request->discount >= 0){
            Session::put('pos.discount', $request->discount);
        }
        return view('backend.pos.cart');
    }

    //set Shipping Cost
    public function setShipping(Request $request){
        if($request->shipping != null){
            Session::put('pos.shipping', $request->shipping);
        }
        return view('backend.pos.cart');
    }

    //order summary
    public function get_order_summary(Request $request){
        return view('backend.pos.order_summary');
    }

   //order place
   public function order_store(Request $request)
   {
       $request->merge(['temp_usder_id' => Session::get('pos.temp_user_id'), 'shippingInfo' => Session::get('pos.shipping_info'), 'shippingCost' => Session::get('pos.shipping', 0), 'discount' => Session::get('pos.discount')]);
       $response = PosUtility::orderStore($request->except(['_token']));

       if ($response['success']) {
           Session::forget('pos.shipping_info');
           Session::forget('pos.shipping');
           Session::forget('pos.discount');
           Session::forget('pos.user_id');
           Session::forget('pos.temp_user_id');
       }

       return $response;
   }

    public function configuration()
    {
        return view('seller.pos.pos_activation');
    }

    public function posConfigurationUpdate (Request $request) {
        $shop = auth()->user()->shop;
        $shop->thermal_printer_width = $request->thermal_printer_width;
        $shop->save();

        flash(translate('Pos Configuration Updated Successfully'));
        return back();
    }

    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        if(auth()->user()->id != $order->seller_id) {
            return back();
        }
        $print_width = get_setting('print_width_seller_pos');
        if ($print_width == null) {
            flash(translate('Print Size does not set for thermal printer from POS configuration'))->warning();
            return back();
        }
        
        $pdf_style_data = FontUtility::get_font_family();
        
        $html = view('backend.pos.thermal_invoice', compact('order', 'pdf_style_data'));

        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [$print_width, 1000]]);
        $mpdf->WriteHTML($html);
        // $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->page   = 0;
        $mpdf->state  = 0;
        unset($mpdf->pages[0]);
        // The $p needs to be passed by reference
        $p = 'P';
        // dd($mpdf->y);
        $mpdf->_setPageSize(array($print_width, $mpdf->y), $p);
        
        $mpdf->addPage();
        $mpdf->WriteHTML($html);

        $mpdf->Output('order-' . $order->code . '.pdf', 'I');
    }
}
