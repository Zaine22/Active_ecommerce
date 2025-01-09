<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Validation\Rule;

class WholesaleProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $approved = 1;
        if (auth()->user()->user_type == 'seller') {
            $added_by = 'seller';
            $user_id = auth()->user()->id;
            if (get_setting('product_approve_by_admin') == 1) {
                $approved = 0;
            }
        } else {
            $added_by = 'admin';
            $user_id = User::where('user_type', 'admin')->first()->id;
        }
        
        $shipping_cost = 0;
        if (isset($this->shipping_type)) {
            if ($this->shipping_type == 'flat_rate') {
                $shipping_cost = $this->flat_shipping_cost;
            }
        }

        $this->merge([
            'slug'              => ($this->slug == null) ? preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($this->name))) : $this->slug,
            'user_id'           => $user_id,
            'approved'          => $approved,
            'wholesale_product' => 1,
            'added_by'          => $added_by,
            'shipping_cost'     => $shipping_cost,
            'published'         => ($this->button == 'unpublish') ? 0 : 1,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [];

        $rules['name']                = 'required|max:255';
        $rules['slug']                = ['required', 'max:255', Rule::unique('products')->ignore($this->id)];
        $rules['category_ids']        = 'required';
        $rules['category_id']         = ['required', Rule::in($this->category_ids)];
        $rules['unit']                = 'required';
        $rules['min_qty']             = 'required|numeric';
        $rules['unit_price']          = 'required|numeric|gt:0';
        $rules['wholesale_min_qty.*'] = 'required';
        $rules['wholesale_max_qty.*'] = 'required';
        $rules['wholesale_price.*']   = 'required';
        $rules['current_stock']       = 'required|numeric';

        return $rules;
    }

    /**
     * Get the validation messages of rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'                => 'Product name is required',
            'category_ids.required'        => 'Product category is required',
            'category_id.required'         => 'Main Category is required',
            'category_id.in'               => 'Main Category must be within selected categories',
            'unit.required'                => 'Unit field is required',
            'min_qty.required'             => 'Minimum purchase quantity is required',
            'min_qty.numeric'              => 'Minimum purchase must be numeric',
            'unit_price.required'          => 'Unit price is required',
            'unit_price.numeric'           => 'Unit price must be numeric',
            'current_stock.required'       => 'Current stock is required',
            'current_stock.numeric'        => 'Current stock must be numeric',
            'wholesale_min_qty.*.required' => 'Product minimum qantity is required',
            'wholesale_max_qty.*.required' => 'Product maximum qantity is required',
            'wholesale_price.*.required'   => 'Product price is required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    public function failedValidation(Validator $validator)
    {
        // dd($this->expectsJson());
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'message' => $validator->errors()->all(),
                'result' => false
            ], 422));
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
