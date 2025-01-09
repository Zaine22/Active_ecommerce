<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ProductStock;
use App\Models\ProductTranslation;
use App\Models\Product;
use App\Models\WholesalePrice;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WholesaleService
{
    public function store(array $data)
    {
        $collection = collect($data);
        
        $tags = array();
        if ($collection['tags'][0] != null) {
            foreach (json_decode($collection['tags'][0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $collection['tags'] = implode(',', $tags);

        if ($collection['meta_title'] == null) {
            $collection['meta_title'] = $collection['name'];
        }
        if ($collection['meta_description'] == null) {
            $collection['meta_description'] = strip_tags($collection['description']);
        }

        if ($collection['meta_img'] == null) {
            $collection['meta_img'] = $collection['thumbnail_img'];
        } 
        
        $choice_options = array();
        $collection['choice_options'] = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        $collection['has_warranty'] = isset($collection['has_warranty']) ? 1 : 0;
        
        $data = $collection->toArray();

        $product = Product::create($data);

        $product_stock              = new ProductStock;
        $product_stock->product_id  = $product->id;
        $product_stock->variant     = '';
        $product_stock->price       = $collection['unit_price'];
        $product_stock->sku         = $collection['sku'];
        $product_stock->qty         = $collection['current_stock'];
        $product_stock->save();

        if(request()->has('wholesale_price')){
            foreach(request()->wholesale_price as $key => $price){
                $wholesale_price = new WholesalePrice;
                $wholesale_price->product_stock_id = $product_stock->id;
                $wholesale_price->min_qty = request()->wholesale_min_qty[$key];
                $wholesale_price->max_qty = request()->wholesale_max_qty[$key];
                $wholesale_price->price = $price;
                $wholesale_price->save();
            }
        }
        
        return $product;

    }

    public function update(Request $request , $id)
    {
        $product                    = Product::findOrFail($id);
        $product->category_id       = $request->category_id;
        $product->brand_id          = $request->brand_id;
        $product->barcode           = $request->barcode;
        $product->cash_on_delivery = 0;
        $product->featured = 0;
        $product->todays_deal = 0;
        $product->is_quantity_multiplied = 0;

        if (addon_is_activated('refund_request')) {
            if ($request->refundable != null) {
                $product->refundable = 1;
                $product->refund_note_id = $request->refund_note_id;
            }
            else {
                $product->refundable = 0;
            }
        }

        if($request->lang == env("DEFAULT_LANGUAGE")){
            $product->name          = $request->name;
            $product->unit          = $request->unit;
            $product->description   = $request->description;
            $product->slug          = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->slug)));
        }

        if($request->slug == null){
            $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($request->name)));
        }

        

        $product->photos                 = $request->photos;
        $product->thumbnail_img          = $request->thumbnail_img;
        $product->min_qty                = $request->min_qty;
        $product->low_stock_quantity     = $request->low_stock_quantity;
        $product->stock_visibility_state = $request->stock_visibility_state;

        $tags = array();
        if($request->tags[0] != null){
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags           = implode(',', $tags);

        $product->video_provider = $request->video_provider;
        $product->video_link     = $request->video_link;
        $product->unit_price     = $request->unit_price;
        $product->discount       = $request->discount;
        $product->discount_type     = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime( $date_var[1]);
        }

        $product->shipping_type  = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;

        if (addon_is_activated('club_point')) {
            if($request->earn_point) {
                $product->earn_point = $request->earn_point;
            }
        }

        if ($request->has('shipping_type')) {
            if($request->shipping_type == 'free'){
                $product->shipping_cost = 0;
            }
            elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            }
            elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }

        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }
        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }

        if ($request->has('featured')) {
            $product->featured = 1;
        }

        if ($request->has('todays_deal')) {
            $product->todays_deal = 1;
        }

        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_img          = $request->meta_img;

        if($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }

        $product->pdf = $request->pdf;

        $colors = array();
        $product->colors = json_encode($colors);

        $choice_options = array();
        $product->choice_options = json_encode($choice_options, JSON_UNESCAPED_UNICODE);

        $product_stock              = $product->stocks->first();
        $product_stock->price       = $request->unit_price;
        $product_stock->sku         = $request->sku;
        $product_stock->qty         = $request->current_stock;
        $product_stock->save();

        $product->frequently_bought_selection_type = $request->frequently_bought_selection_type;

        $product->has_warranty = isset($request->has_warranty) ? 1 : 0;
        $product->warranty_id = $request->warranty_id;
        $product->warranty_note_id = $request->warranty_note_id;

        $product->save();

        foreach ($product->stocks->first()->wholesalePrices as $key => $wholesalePrice) {
            $wholesalePrice->delete();
        }

        if($request->has('wholesale_price')){
            foreach($request->wholesale_price as $key => $price){
                $wholesale_price = new WholesalePrice;
                $wholesale_price->product_stock_id = $product_stock->id;
                $wholesale_price->min_qty = $request->wholesale_min_qty[$key];
                $wholesale_price->max_qty = $request->wholesale_max_qty[$key];
                $wholesale_price->price = $price;
                $wholesale_price->save();
            }
        }
        $request->merge(['product_id' => $product->id]);
        

        //Product categories
        $product->categories()->sync($request->category_ids);

        //Flash Deall
        if($request->flash_deal_id) {
            (new ProductFlashDealService)->store($request->only([
                'flash_deal_id', 'flash_discount', 'flash_discount_type'
            ]), $product);
        }

        
        //VAT & Tax
        if ($request->tax_id) {
            $product->taxes()->delete();
            (new ProductTaxService)->store($request->only([
                'tax_id', 'tax', 'tax_type', 'product_id'
            ]));
        }
        
        // Frequently Bought Products
        $product->frequently_bought_products()->delete();
        (new FrequentlyBoughtProductService)->store($request->only([
            'product_id', 'frequently_bought_selection_type', 'fq_bought_product_ids', 'fq_bought_product_category_id'
        ]));

        // Product Translations
        ProductTranslation::updateOrCreate(
            $request->only([
                'lang', 'product_id'
            ]),
            $request->only([
                'name', 'unit', 'description'
            ])
        );
    }

    public function destroy($id){
        $product = Product::findOrFail($id);
        $product->product_translations()->delete();
        $product->categories()->detach();
        $product->stocks()->delete();
        $product->taxes()->delete();
        $product->frequently_bought_products()->delete();
        $product->last_viewed_products()->delete();
        Product::destroy($id);
        Cart::where('product_id', $id)->delete();
        Wishlist::where('product_id', $id)->delete();
    }
}
