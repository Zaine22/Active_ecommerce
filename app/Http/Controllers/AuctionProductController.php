<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Services\AuctionService;
use App\Models\ProductQuery;
use Artisan;
use Auth;
use Carbon\Carbon;
use DB;

class AuctionProductController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_all_auction_products'])->only('all_auction_product_list');
        $this->middleware(['permission:view_inhouse_auction_products'])->only('inhouse_auction_products');
        $this->middleware(['permission:view_seller_auction_products'])->only('seller_auction_products');
        $this->middleware(['permission:add_auction_product'])->only('product_create_admin');
        $this->middleware(['permission:edit_auction_product'])->only('product_edit_admin');
        $this->middleware(['permission:delete_auction_product'])->only('product_destroy_admin');
        $this->middleware(['permission:view_auction_product_orders'])->only('admin_auction_product_orders');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Auction products list admin panel
    public function all_auction_product_list(Request $request)
    {
        $sort_search = null;
        $seller_id = null;
        $type = 'all';
        $products = Product::orderBy('created_at', 'desc')->where('auction_product', 1);

        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('auction.auction_products.index', compact('products', 'sort_search', 'type', 'seller_id'));
    }

    public function inhouse_auction_products(Request $request)
    {
        $sort_search = null;
        $seller_id = null;
        $type = 'in_house';
        $products = Product::where('added_by', 'admin')->orderBy('created_at', 'desc')->where('auction_product', 1);
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('auction.auction_products.index', compact('products', 'sort_search', 'type', 'seller_id'));
    }

    public function seller_auction_products(Request $request)
    {
        $sort_search = null;
        $seller_id = null;
        $type = 'seller';
        $products = Product::where('added_by', 'seller')->orderBy('created_at', 'desc')->where('auction_product', 1);

        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }

        if ($request->search != null) {
            $products = $products
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('auction.auction_products.index', compact('products', 'sort_search', 'type', 'seller_id'));
    }
    // Auction products list admin panel end

    // Auction Products list in Seller panel
    public function auction_product_list_seller(Request $request)
    {
        if (get_setting('seller_auction_product') == 0) {
            return redirect()->route('home');
        }

        $sort_search = null;
        $products = Product::where('auction_product', 1)->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        if ($request->search != null) {
            $products = $products
                ->where('name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('auction.frontend.seller.auction_product_list', compact('products', 'sort_search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_create_admin()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('auction.auction_products.create', compact('categories'));
    }

    public function product_create_seller()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        if (get_setting('seller_auction_product') == 1) {
            if (addon_is_activated('seller_subscription')) {
                if (Auth::user()->shop->seller_package != null && Auth::user()->shop->seller_package->product_upload_limit > Auth::user()->products()->count()) {
                    return view('auction.frontend.seller.auction_product_upload', compact('categories'));
                } else {
                    flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                    return back();
                }
            } else {
                return view('auction.frontend.seller.auction_product_upload', compact('categories'));
            }
        }
    }

    public function product_store_admin(ProductRequest $request)
    {
        (new AuctionService)->store($request);
        return redirect()->route('auction.inhouse_products');
    }

    public function product_store_seller(ProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (
                Auth::user()->shop->seller_package == null ||
                Auth::user()->shop->seller_package->product_upload_limit <= Auth::user()->products()->count()
            ) {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }

        (new AuctionService)->store($request);
        return redirect()->route('auction_products.seller.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function product_destroy_admin($id)
    {
        (new AuctionService)->destroy($id);
        return redirect()->route('auction.inhouse_products');
    }

    public function product_destroy_seller($id)
    {
        (new AuctionService)->destroy($id);
        return redirect()->route('auction_products.seller.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function product_edit_admin(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('auction.auction_products.edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function product_edit_seller(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('auction.frontend.seller.auction_product_edit', compact('product', 'categories', 'tags', 'lang'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function product_update_admin(ProductRequest $request, $id)
    {
        (new AuctionService)->update($request, $id);
        return back();
    }

    public function product_update_seller(ProductRequest $request, $id)
    {
        (new AuctionService)->update($request, $id);
        return back();
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }


    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;

        if ($product->added_by == 'seller' && addon_is_activated('seller_subscription')) {
            $seller = $product->user->shop;
            if ($seller->package_invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->package_invalid_at), false) <= 0) {
                return 0;
            }
        }

        $product->save();
        return 1;
    }

    public function all_auction_products()
    {
        $products = get_auction_products(null, 15);
        return view('auction.frontend.all_auction_products', compact('products'));
    }

    public function auction_product_details(Request $request, $slug)
    {
        $detailedProduct  = Product::where('slug', $slug)->first();
        if ($detailedProduct != null) {
            $product_queries = ProductQuery::where('product_id', $detailedProduct->id)->where('customer_id', '!=', Auth::id())->latest('id')->paginate(3);
            $total_query = ProductQuery::where('product_id', $detailedProduct->id)->count();
            $reviews = $detailedProduct->reviews()->paginate(3);

            // review status
            $review_status = 0;
            if (Auth::check()) {
                $OrderDetail = OrderDetail::with(['order' => function ($q) {
                    $q->where('user_id', Auth::id());
                }])->where('product_id', $detailedProduct->id)->where('delivery_status', 'delivered')->first();
                $review_status = $OrderDetail ? 1 : 0;
            }

            if(get_setting('last_viewed_product_activation') == 1 && Auth::check() && auth()->user()->user_type == 'customer'){
                lastViewedProducts($detailedProduct->id, auth()->user()->id);
            }

            return view('frontend.product_details', compact('detailedProduct', 'product_queries', 'total_query', 'reviews', 'review_status'));
        }

        abort(404);
    }

    public function purchase_history_user()
    {
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.user_id', Auth::user()->id)
            ->where('products.auction_product', '1')
            ->select('order_details.order_id as id')
            ->paginate(15);
        return view('auction.frontend.purchase_history', compact('orders'));
    }

    public function admin_auction_product_orders(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $date = $request->date;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('products.auction_product', '1')
            ->select('orders.id');

        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->paginate(15);

        return view('auction.auction_product_orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'date'));
    }

    public function auction_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order_shipping_address = json_decode($order->shipping_address);
        $delivery_boys = User::where('city', $order_shipping_address->city)
            ->where('user_type', 'delivery_boy')
            ->get();

        $order->viewed = 1;
        $order->save();

        return view('auction.auction_product_order_details', compact('order', 'delivery_boys'));
    }

    public function seller_auction_product_orders(Request $request)
    {
        if (get_setting('seller_auction_product') == 0) {
            return redirect()->route('home');
        }

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->where('orders.seller_id', Auth::user()->id)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('products.auction_product', '1')
            ->select('orders.id');


        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')) {
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%' . $sort_search . '%');
        }

        $orders = $orders->paginate(15);
        return view('auction.frontend.seller.auction_product_orders', compact('orders', 'payment_status', 'delivery_status', 'sort_search'));
    }
}
