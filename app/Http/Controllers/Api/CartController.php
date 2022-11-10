<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        try {
            $carts = Cart::with('product')->where('customer_id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')
                ->get();
        } catch (\Exception $errors) {
            $this->format(
                '10',
                'Get Item Error',
                $errors->getMessage()
            );
        }
        return CartResource::collection($carts);
    }
}