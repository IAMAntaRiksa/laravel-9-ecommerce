<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CheckoutResource;
use App\Models\Cart;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;

class CheckOutController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction =  config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $random = '';
            $length = 10;

            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = 'INV-' . Str::upper($random);

            $invoice = Invoice::create([
                'invoice' => $no_invoice,
                'customer_id' => auth()->user()->id,
                'courier' => $request->courier,
                'service' => $request->service,
                'cost_courier' => $request->cost_courier,
                'weight' => $request->weight,
                'name' => $request->name,
                'phone' => $request->phone,
                'city_id' => $request->city_id,
                'province_id' => $request->province_id,
                'address' => $request->address,
                'grand_total' => $request->grand_total,
                'status' => 'pending',
            ]);

            $carts = Cart::where('customer_id', auth()->user()->id)->get();

            foreach ($carts as $cart) {
                $invoice->orders()->create([
                    'invoice_id'    => $invoice->id,
                    'invoice'       => $no_invoice,
                    'product_id'    => $cart->product_id,
                    'product_name'  => $cart->product->title,
                    'image'         => $cart->product->image,
                    'qty'           => $cart->qty,
                    'price'         => $cart->price,
                ]);
            }
            //remove cart by customer
            Cart::with('product')
                ->where('customer_id', auth()->user()->id)
                ->delete();

            $payload = array(
                'transaction_details' => array(
                    'order_id' => $invoice->invoice,
                    'gross_amount' => $invoice->grand_total,
                ),
                'customer_details' => array(
                    'first_name' => $invoice->name,
                    'email' =>  auth()->user()->email,
                    'phone' => $invoice->phone,
                    'billing_address' => [
                        'address' => $invoice->address
                    ]
                ),
            );
            $snapToken = Snap::getSnapToken($payload);
            $invoice->snap_token = $snapToken;

            $this->response['snap_token'] = $snapToken;

            try {
                $invoice->save();
            } catch (\Exception $errors) {
                $return = $this->format(
                    '10',
                    'Get Item Error',
                    $errors->getMessage(),
                );
                return response()->json($return);
            }
        });

        return new CheckoutResource($this->response);
    }
}