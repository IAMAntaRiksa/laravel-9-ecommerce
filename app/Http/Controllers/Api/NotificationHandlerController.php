<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class NotificationHandlerController extends Controller
{
    public function index(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $serverKey = config('services.midtrans.serverKey');
        $input = $notification->order_id . $notification->status_code . $notification->gross_amount . $serverKey;
        $validSignatureKey = hash($input, "sha512");

        if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
        }

        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $orderId = $notification->order_id;
        $fraud = $notification->fraud_status;

        //data tranaction
        $data_transaction = Invoice::where('invoice', $orderId)->first();

        if ($transaction == "capture") {
            if ($type == "credit_card") {
                if ($fraud == 'challenge') {
                    $data_transaction->update(['status' => 'pending']);
                } else {
                    $data_transaction->update(['status' => 'success']);
                }
            }
        } elseif ($transaction == "settlement") {

            $data_transaction->update([
                'status' => 'success'
            ]);
            foreach ($data_transaction->orders()->get() as $order) {
                $product = Product::where($order->product_id)->first();
                $product->create([
                    'stock' => $product->stock - $order->qty
                ]);
            }
        } elseif ($transaction == "pending") {
            $data_transaction->update([
                'status' => 'pending'
            ]);
        } elseif ($transaction == "deny") {
            $data_transaction->update([
                'status' => 'failed'
            ]);
        } elseif ($transaction == 'expire') {
            $data_transaction->update([
                'status' => 'expired'
            ]);
        } elseif ($transaction == 'cancel') {

            $data_transaction->update([
                'status' => 'failed'
            ]);
        }
    }
}