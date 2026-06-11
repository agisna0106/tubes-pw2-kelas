<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID produk saat ini untuk pengecualian unique barcode saat update
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            'category_id' => 'required|exists:categories,id',
            'barcode' => [
                'required',
                'string',
                Rule::unique('products', 'barcode')->ignore($productId),
            ],
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0|gte:purchase_price',
            'minimum_stock' => 'required|integer|min:0',
        ];
    }
}