<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    // public function receiveCallback(Request $request)
    // {
    //     // Log isi callback ke storage/logs/laravel.log
    //     Log::info('Midtrans Callback:', $request->all());

    //     $orderId = $request->order_id;
    //     $transactionStatus = $request->transaction_status;
    //     $paymentType = $request->payment_type;
    //     $fraudStatus = $request->fraud_status;

    //     // Temukan order berdasarkan ID
    //     $order = Order::find($orderId);

    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404);
    //     }

    //     // Tentukan status berdasarkan callback Midtrans
    //     switch ($transactionStatus) {
    //         case 'capture':
    //         case 'settlement':
    //             $order->payment_status = 'paid_dp';
    //             break;
    //         case 'pending':
    //             $order->payment_status = 'unpaid';
    //             break;
    //         case 'deny':
    //         case 'cancel':
    //         case 'expire':
    //             $order->payment_status = 'failed';
    //             break;
    //     }

    //     $order->save();

    //     return response()->json(['message' => 'Callback received and order updated']);
    // }
    public function receiveCallback(Request $request)
    {
        Log::info('📥 Midtrans Callback:', $request->all());

        $orderId = $request->order_id; // contoh: "INV-1754301162"
        $transactionStatus = $request->transaction_status;
        $grossAmount = $request->gross_amount;

        // Cari order di database berdasarkan order_id
        $order = Order::where('invoice', $orderId)->first(); // <- ubah dari 'invoice_number' ke 'invoice'

        if (!$order) {
            Log::warning("❌ Order not found: $orderId");
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'settlement') {
            $order->payment_status = 'paid_dp';
            $order->save();

            // Kurangi stok setiap item yang dipesan
            foreach ($order->orderItems as $item) {
                $product = $item->product;
                if ($product && $product->stock_barang >= $item->quantity) {
                    $product->stock_barang -= $item->quantity;
                    $product->save();
                    Log::info("📦 Stock dikurangi untuk Produk ID {$product->id}, sisa: {$product->stock_barang}");
                } else {
                    Log::warning("⚠️ Stok tidak cukup atau produk tidak ditemukan untuk item: {$item->id}");
                }
            }

            Log::info("✅ Payment DP berhasil & stok dikurangi untuk Order: $orderId");

        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'expire' || $transactionStatus == 'failure') {
            $order->payment_status = 'failed';
            $order->save();

            Log::info("❌ Payment gagal/expired untuk Order: $orderId");
        }

        return response()->json(['message' => 'Callback processed']);
    }

}
