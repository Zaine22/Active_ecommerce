<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CoreComponentRepository;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Services\WholesaleService;
use App\Services\ProductTaxService;
use App\Services\ProductFlashDealService;
use App\Services\FrequentlyBoughtProductService;
use App\Http\Requests\WholesaleProductRequest;
use Auth;
use Artisan;

class WholesaleProductController extends Controller
{
    public function __construct() {
        // Staff Permission Check
        $this->middleware(['permission:view_all_wholesale_products'])->only('all_wholesale_products');
        $this->middleware(['permission:view_inhouse_wholesale_products'])->only('in_house_wholesale_products');
        $this->middleware(['permission:view_sellers_wholesale_products'])->only('seller_wholesale_products');
        $this->middleware(['permission:add_wholesale_product'])->only('product_create_admin');
        $this->middleware(['permission:edit_wholesale_product'])->only('product_edit_admin');
        $this->middleware(['permission:delete_wholesale_product'])->only('product_destroy_admin');
    }

    public function all_wholesale_products(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $type = 'All';
        $col_name = null;
        $query = null;
        $sort_search = null;
        $seller_id  = null;

        $products = Product::where('wholesale_product', 1)->orderBy('created_at', 'desc');

        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }

        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('wholesale.products.index', compact('products','type', 'col_name', 'query', 'sort_search','seller_id'));
    }

    public function in_house_wholesale_products(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $type = 'In House';
        $col_name = null;
        $query = null;
        $sort_search = null;

        $products = Product::where('wholesale_product', 1)->where('added_by','admin')->orderBy('created_at', 'desc');

        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('wholesale.products.index', compact('products','type', 'col_name', 'query', 'sort_search'));
    }

    public function seller_wholesale_products(Request $request)
    {
        CoreComponentRepository::instantiateShopRepository();

        $type = 'Seller';
        $col_name = null;
        $query = null;
        $sort_search = null;
        $seller_id  = null;

        $products = Product::where('wholesale_product', 1)->where('added_by','seller')->orderBy('created_at', 'desc');

        if ($request->has('user_id') && $request->user_id != null) {
            $products = $products->where('user_id', $request->user_id);
            $seller_id = $request->user_id;
        }
        
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('wholesale.products.index', compact('products','type', 'col_name', 'query', 'sort_search','seller_id'));
    }

    // Wholesale Products list in Seller panel 
    public function wholesale_products_list_seller(Request $request)
    {
        $sort_search = null;
        $col_name = null;
        $query = null;
        $products = Product::where('wholesale_product',1)->where('user_id',Auth::user()->id)->orderBy('created_at', 'desc');
        if ($request->type != null){
            $var = explode(",", $request->type);
            $col_name = $var[0];
            $query = $var[1];
            $products = $products->orderBy($col_name, $query);
            $sort_type = $request->type;
        }
        if ($request->search != null){
            $products = $products
                        ->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $products = $products->paginate(15);

        return view('wholesale.frontend.seller_products.index', compact('products', 'sort_search','col_name'));
    }

    public function product_create_admin()
    {
        CoreComponentRepository::initializeCache();

        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('wholesale.products.create', compact('categories'));
   
    }

    public function product_create_seller()
    {
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        if(get_setting('seller_wholesale_product') == 1){
            if(addon_is_activated('seller_subscription')){
                if(Auth::user()->shop->seller_package != null && Auth::user()->shop->seller_package->product_upload_limit > Auth::user()->products()->count()){
                    return view('wholesale.frontend.seller_products.create', compact('categories'));
                }
                else {
                    flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                    return back();
                }
            }
            return view('wholesale.frontend.seller_products.create', compact('categories'));
        }     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function product_store_admin(WholesaleProductRequest $request)
    { 
        $product = (new WholesaleService)->store($request->except([
            '_token', 'button', 'flat_shipping_cost', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]));
        $request->merge(['product_id' => $product->id]);

        //Product categories
        $product->categories()->attach($request->category_ids);

        //VAT & Tax
        if ($request->tax_id) {
            (new productTaxService)->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        //Flash Deal
        (new productFlashDealService)->store($request->only([
            'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]), $product);

        // Frequently Bought Products
        (new FrequentlyBoughtProductService)->store($request->only([
            'product_id', 'frequently_bought_selection_type', 'fq_bought_product_ids', 'fq_bought_product_category_id'
        ]));

        // Product Translations
        $request->merge(['lang' => env('DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('wholesale_products.in_house');
    }

    public function product_store_seller(WholesaleProductRequest $request)
    {
        if (addon_is_activated('seller_subscription')) {
            if (
                (Auth::user()->shop->seller_package == null) ||
                (Auth::user()->shop->seller_package->product_upload_limit <= Auth::user()->products()->count())
            ) {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }
       
        $product = (new WholesaleService)->store($request->except([
            '_token', 'tax_id', 'tax', 'tax_type', 'flash_deal_id', 'flash_discount', 'flash_discount_type'
        ]));
        $request->merge(['product_id' => $product->id]);

        //Product categories
        $product->categories()->attach($request->category_ids);
        
        (new FrequentlyBoughtProductService)->store($request->only([
            'product_id', 'frequently_bought_selection_type', 'fq_bought_product_ids', 'fq_bought_product_category_id'
        ]));
        
        //VAT & Tax
        if ($request->tax_id) {
            (new productTaxService)->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }

        // Product Translations
        $request->merge(['lang' => env('DEFAULT_LANGUAGE')]);
        ProductTranslation::create($request->only([
            'lang', 'name', 'unit', 'description', 'product_id'
        ]));

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        
        return redirect()->route('seller.wholesale_products_list');
    }


    public function product_edit_admin(Request $request, $id)
    {
        CoreComponentRepository::initializeCache();

        $product = Product::findOrFail($id);
        if($product->digital == 1) {
            return redirect('digitalproducts/' . $id . '/edit');
        }

        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();

        return view('wholesale.products.edit', compact('product', 'categories', 'tags','lang'));
    }

    public function product_edit_seller(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if($product->digital == 1) {
            return redirect('digitalproducts/' . $id . '/edit');
        }

        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
            
        return view('wholesale.frontend.seller_products.edit', compact('product', 'categories', 'tags','lang'));
    }

   
    public function product_update_admin(WholesaleProductRequest $request, $id)
    {
        (new WholesaleService)->update($request, $id);
        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return back();
    }

    public function product_update_seller(WholesaleProductRequest $request, $id)
    {
        (new WholesaleService)->update($request, $id);
        flash(translate('Product has been updated successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function product_destroy_admin($id)
    {
        (new WholesaleService)->destroy($id);
        flash(translate('Product has been deleted successfully'))->success();
            
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return back();
    }

    public function product_destroy_seller($id)
    {
        (new WholesaleService)->destroy($id);
        flash(translate('Product has been deleted successfully'))->success();
            
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return back();
    }
}
