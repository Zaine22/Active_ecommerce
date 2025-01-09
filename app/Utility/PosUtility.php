<?php

namespace App\Utility;

use App\Models\ProductStock;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Session;
use Mail;
use App\Mail\InvoiceEmailManager;
use App\Models\User;

class PosUtility
{
    public static function product_search($request_data): object
    {
        $product_query = ProductStock::query()->join('products', 'product_stocks.product_id', '=', 'products.id');

        if (auth()->user()->user_type == 'seller') {
            $product_query->where('products.user_id', auth()->user()->id);
        } else {
            $product_query->where('products.added_by', 'admin');
        }
        $products = $product_query->where('products.auction_product', 0)
            ->where('products.wholesale_product', 0)
            ->where('products.published', 1)
            ->where('products.approved', 1)
            ->select('products.*', 'product_stocks.id as stock_id', 'product_stocks.variant', 'product_stocks.price as stock_price', 'product_stocks.qty as stock_qty', 'product_stocks.image as stock_image')
            ->orderBy('products.created_at', 'desc');


        if ($request_data['category'] != null) {
            $arr = explode('-', $request_data['category']);
            if ($arr[0] == 'category') {
                $category_ids = CategoryUtility::children_ids($arr[1]);
                $category_ids[] = $arr[1];
                $products = $products->whereIn('products.category_id', $category_ids);
            }
        }

        if ($request_data['brand'] != null) {
            $products = $products->where('products.brand_id', $request_data['brand']);
        }

        if ($request_data['keyword'] != null) {
            $products = $products->where('products.name', 'like', '%' . $request_data['keyword'] . '%')->orWhere('products.barcode', $request_data['keyword']);
        }

        return $products->paginate(16);
    }

    public static function get_shipping_address($request): array
    {
        if ($request->address_id != null) {
            $address = Address::findOrFail($request->address_id);
            $data['name'] = $address->user->name;
            $data['email'] = $address->user->email;
            $data['address'] = $address->address;
            $data['country'] = $address->country->name;
            $data['state'] = $address->state->name;
            $data['city'] = $address->city->name;
            $data['postal_code'] = $address->postal_code;
            $data['phone'] = $address->phone;
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;
            $data['country'] = Country::find($request->country_id)->name;
            $data['state'] = State::find($request->state_id)->name;
            $data['city'] = City::find($request->city_id)->name;
            $data['postal_code'] = $request->postal_code;
            $data['phone'] = $request->phone;
        }

        return $data;
    }

    public static function addToCart($stockId, $userID, $temUserId)
    {
        $productStock   = ProductStock::find($stockId);
        $product        = $productStock->product;
        $quantity       = $product->min_qty;

        if ($productStock->qty < $product->min_qty && $product->digital == 0) {
            return array(
                'success' => 0,
                'message' => translate("This product doesn't have enough stock for minimum purchase quantity ") . $product->min_qty
            );
        }

        $cart = Cart::firstOrNew([
            'variation' => $productStock->variant,
            'user_id' => $userID,
            'temp_user_id' => $temUserId,
            'product_id' => $product->id
        ]);

        if ($cart->exists) {
            if ($product->digital == 1) {
                return array(
                    'success' => 0,
                    'message' => translate("This product is alreday in the cart")
                );
            } else {
                $quantity = $cart->quantity + 1;
                if ($productStock->qty < $quantity) {
                    return array(
                        'success' => 0,
                        'message' => translate("This product doesn't have more stock.")
                    );
                }
            }
        }

        $price = CartUtility::get_price($product, $productStock, $quantity);
        $tax = CartUtility::tax_calculation($product, $price);
        CartUtility::save_cart_data($cart, $product, $price, $tax, $quantity);
        return array('success' => 1, 'message' => 'Added to cart successfully');
    }

    public static function updateCartItemQuantity($cart, $data)
    {
        $product = Product::find($cart->product_id);
        $product_stock = $product->stocks->where('variant', $cart->variation)->first();

        if ($product_stock->qty < $data['quantity']) {
            $response['success'] = 0;
            $response['message'] = translate("This product doesn't have more stock.");
        } else {
            $cart->quantity = $data['quantity'];
            $cart->save();
            $response['success'] = 1;
            $response['message'] = translate("Updated the item successfully.");
        }

        return $response;
    }

    public static function updateCartOnUserChange($data)
    {
        $userID             = $data['userId'];
        $sessionUserId      = Session::has('pos.user_id') ? Session::get('pos.user_id') : null;
        $sessionTemUserId   = Session::has('pos.temp_user_id') ? Session::get('pos.temp_user_id') : null;
        $carts              = get_pos_user_cart();

        // If user is selected but user not in session or Session user is not this user, set it to session
        if ($userID) {
            if ($carts) {
                self::updatePosUserCartData($carts, $userID, null);
            }

            if (!$sessionUserId || ($sessionUserId != $userID)) {
                Session::put('pos.user_id', $userID);
            }
            Session::forget('pos.temp_user_id');
        }

        // If user is not selected, and if session has not Temp user ID, get it or set it
        if (!$userID) {
            if (!$sessionTemUserId) {
                $sessionTemUserId = bin2hex(random_bytes(10));
                Session::put('pos.temp_user_id', $sessionTemUserId);
            }
            if ($carts) {
                self::updatePosUserCartData($carts, null, $sessionTemUserId);
            }
            Session::forget('pos.user_id');
        }
    }

    public static function updatePosUserCartData($carts, $userID, $tempUsderID)
    {
        foreach ($carts as $cartItem) {
            $userCartItem = Cart::where('user_id', $userID)->where('temp_user_id', $tempUsderID)->where('product_id', $cartItem->product_id)->where('variation', $cartItem->variation)->first();
            if ($userCartItem) {
                $quantity = $userCartItem->quantity + $cartItem->quantity;
                $product_qty = $cartItem->product->stocks()->where('variant', $cartItem->$cartItem)->first();
                $quantity = $product_qty > $quantity ? $product_qty : $quantity;

                $userCartItem->update(['quantity' => $quantity]);
                $cartItem->delete();
            } else {
                $cartItem->update(['user_id' => $userID, 'temp_user_id' => $tempUsderID]);
            }
        }
    }

    public static function orderStore($data)
    {
        $shippingInfo = $data['shippingInfo'];
        if ($shippingInfo == null || $shippingInfo['name'] == null || $shippingInfo['phone'] == null || $shippingInfo['address'] == null) {
            return array('success' => 0, 'message' => translate("Please Add Shipping Information."));
        } else {
            $carts = get_pos_user_cart($data['user_id'], $data['temp_usder_id']);
            if (count($carts) > 0) {
                $order = new Order();
                $userId = $data['user_id'];
                if ($userId == null) {
                    $order->guest_id  = $carts[0]->temp_user_id;
                } else {
                    $order->user_id = $userId;
                }
                $order->shipping_address = json_encode($shippingInfo);

                $order->payment_type    = $data['payment_type'];
                $order->delivery_viewed = '0';
                $order->payment_status_viewed = '0';
                $order->code            = date('Ymd-His') . rand(10, 99);
                $order->date            = strtotime('now');
                $order->payment_status  = $data['payment_type'] != 'cash_on_delivery' ? 'paid' : 'unpaid';
                $order->payment_details = $data['payment_type'];
                $order->order_from      = 'pos';

                if ($data['payment_type'] == 'offline_payment') {
                    if ($data['offline_trx_id'] == null) {
                        return array('success' => 0, 'message' => translate("Transaction ID cannot be null."));
                    }
                    $data['name']   = $data['offline_payment_method'];
                    $data['amount'] = $data['offline_payment_amount'];
                    $data['trx_id'] = $data['offline_trx_id'];
                    $data['photo']  = $data['offline_payment_proof'];
                    $order->manual_payment_data = json_encode($data);
                    $order->manual_payment = 1;
                }

                if ($order->save()) {
                    $subtotal = 0;
                    $tax = 0;
                    foreach ($carts as $key => $cartItem) {
                        $product_stock      = $cartItem->product->stocks->where('variant', $cartItem['variation'])->first();
                        $product            = $product_stock->product;
                        $product_variation  = $product_stock->variant;

                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $tax += $cartItem['tax'] * $cartItem['quantity'];

                        if ($product->digital == 0) {
                            if ($cartItem['quantity'] > $product_stock->qty) {
                                $order->delete();
                                return array('success' => 0, 'message' => $product->name . ' (' . $product_variation . ') ' . translate(" just stock outs."));
                            } else {
                                $product_stock->qty -= $cartItem['quantity'];
                                $product_stock->save();
                            }
                        }

                        $order_detail                   = new OrderDetail;
                        $order_detail->order_id         = $order->id;
                        $order_detail->seller_id        = $product->user_id;
                        $order_detail->product_id       = $product->id;
                        $order_detail->payment_status   = $data['payment_type'] != 'cash_on_delivery' ? 'paid' : 'unpaid';
                        $order_detail->variation        = $product_variation;
                        $order_detail->price            = $cartItem['price'] * $cartItem['quantity'];
                        $order_detail->tax              = $cartItem['tax'] * $cartItem['quantity'];
                        $order_detail->quantity         = $cartItem['quantity'];
                        $order_detail->shipping_type    = null;

                        if ($data['shippingCost'] >= 0) {
                            $order_detail->shipping_cost = $data['shippingCost'] / count($carts);
                        } else {
                            $order_detail->shipping_cost = 0;
                        }

                        $order_detail->save();

                        $product->num_of_sale++;
                        $product->save();
                    }

                    $order->grand_total = $subtotal + $tax + $data['shippingCost'];

                    if ($data['discount']) {
                        $order->grand_total -= $data['discount'];
                        $order->coupon_discount = $data['discount'];
                    }

                    $order->seller_id = $product->user_id;
                    $order->save();

                    $array['view']      = 'emails.invoice';
                    $array['subject']   = 'Your order has been placed - ' . $order->code;
                    $array['from']      = env('MAIL_USERNAME');
                    $array['order']     = $order;

                    $admin_products = array();
                    $seller_products = array();

                    foreach ($order->orderDetails as $key => $orderDetail) {
                        if ($orderDetail->product->added_by == 'admin') {
                            array_push($admin_products, $orderDetail->product->id);
                        } else {
                            $product_ids = array();
                            if (array_key_exists($orderDetail->product->user_id, $seller_products)) {
                                $product_ids = $seller_products[$orderDetail->product->user_id];
                            }
                            array_push($product_ids, $orderDetail->product->id);
                            $seller_products[$orderDetail->product->user_id] = $product_ids;
                        }
                    }

                    foreach ($seller_products as $key => $seller_product) {
                        try {
                            Mail::to(User::find($key)->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {
                        }
                    }

                    //sends email to customer with the invoice pdf attached
                    if (env('MAIL_USERNAME') != null) {
                        try {
                            Mail::to($shippingInfo['email'])->queue(new InvoiceEmailManager($array));
                            Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                        } catch (\Exception $e) {
                        }
                    }

                    if ($userId != NULL && $order->payment_status == 'paid') {
                        calculateCommissionAffilationClubPoint($order);
                    }

                    Cart::where('user_id', $order->user_id)->orWhere('temp_user_id', $order->guest_id)->delete();

                    return array('success' => 1, 'message' => translate('Order Completed Successfully.'));
                } else {
                    return array('success' => 0, 'message' => translate('Please input customer information.'));
                }
            }
            return array('success' => 0, 'message' => translate("Please select a product."));
        }
    }
}
