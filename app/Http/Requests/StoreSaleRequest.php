<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('create', Sale::class)) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'seller' => 'required|exists:users,id',
            'customer' => 'required|exists:users,id'
        ];
    }

    public function attributes(): array
    {
        return [
            'seller' => 'vendedor',
            'customer' => 'cliente'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $cart = session('cart', []);

            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    toastr()->error('Produto não encontrado');
                    $validator->errors()->add('product', 'Produto não encontrado.');
                }

                if ($product && $product->quantity < $item['quantity']) {
                    $validator->errors()->add('quantity', 'Quantidade insuficiente de ' . $product->name . ' no estoque.');
                }

                //Substituindo o id do produto pelo objeto no carrinho pra economizar queries
                $item['product'] = $product;

                //Atualizando o item no carrinho
                $cart[array_search($item['product_id'], array_column($cart, 'product_id'))] = $item;

                session(['cart' => $cart]);
            }

            //Exibindo toastr 1 vez só
            if ($validator->errors()->any()) {
                $error = $validator->errors()->first();
                toastr()->error($error);
            }
        });
    }
}
