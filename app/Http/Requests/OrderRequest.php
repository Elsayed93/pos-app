<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return request()->isMethod('POST') ? $this->storeOrder() : $this->updateOrder();
    }

    public function storeOrder()
    {
        return [
            'products' => 'required|array',
        ];
    }

    public function updateOrder()
    {
        return [
            'products' => 'required|array',
        ];
    }

    public function attributes()
    {
        return [
            'products' => __('products.products'),
        ];
    }
}
