<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
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

    public function store(Request $request)
    {
        // check item product sudah ad di cart? jika ad update qty saja
        $item = Cart::where('product_id', $request->product_id)
            ->where('customer_id', auth()->user()->id)->first();
        if ($item) {
            /// incremnt qty
            $item->increment('qty', $request->qty);
            /// price * qty
            $price = $request->price * $item->qty;
            /// weight * qty
            $weight = $request->weight * $item->qty;
            $item->update([
                'price' => $price,
                'weight' => $weight
            ]);
        } else {
            $item = Cart::create([
                'product_id' => $request->product_id,
                'customer_id' => auth()->user()->id,
                'qty' => $request->qty,
                'price' => $request->price,
                'weight' => $request->weight,
            ]);
        }
        return new ProductResource($item->product);
    }

    public function getCartTotal()
    {
        $totalPrice = Cart::with('prodoct')
            ->orderBy('created_at', 'desc')
            ->where('customer_id', auth()->user()->id)
            ->sum('price');
        return response()->json([
            'total' => $totalPrice,
        ]);
    }

    public function getCartTotalWeight()
    {
        $totalWeight = Cart::with('prodoct')
            ->orderBy('created_at', 'desc')
            ->where('customer_id', auth()->user()->id)
            ->sum('weight');
        return response()->json([
            'total' => $totalWeight,
        ]);
    }

    public function removeCart(Request $request)
    {
        Cart::with('product')
            ->whereId($request->cart_id)
            ->delete();
        return response()->noContent();
    }
}