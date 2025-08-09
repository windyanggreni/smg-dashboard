<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderApiController extends Controller
{
    // public function checkout(Request $request, MidtransService $midtransService)
    // {
    //     // Validasi dan simpan order & order_items ke DB terlebih dulu
    //     $user = auth::user();

    //     $order = Order::create([
    //         'user_id' => $user->id,
    //         'total_price' => $request->total_price,
    //         'status' => 'pending',
    //         'invoice' => 'INV-' . time(),
    //         'note' => $request->note,
    //     ]);

    //     foreach ($request->items as $item) {
    //         $order->orderItems()->create([ // ✅ ini relasi yang benar
    //             'product_id' => $item['product_id'],
    //             'quantity' => $item['quantity'],
    //             'unit_price' => $item['unit_price'],
    //             'subtotal' => $item['subtotal'],
    //             'note' => $item['note'],
    //         ]);
    //     }

    //     // Dapatkan Snap Token dari Midtrans
    //     $snapToken = $midtransService->createTransaction($order);

    //     return response()->json([
    //         'snap_token' => $snapToken,
    //         'order_id' => $order->id,
    //     ]);
    // }
    public function checkout(Request $request, MidtransService $midtransService)
    {
        $user = auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $request->total_price,
            'status' => 'pending',
            'invoice' => 'INV-' . time(),
            'note' => $request->note,
        ]);

        foreach ($request->items as $index => $item) {
            $orderItem = $order->orderItems()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
                'note' => $item['note'], // ini catatan item
            ]);

            // Cek apakah user mengunggah file desain
            if ($request->hasFile("items.$index.file")) {
                $file = $request->file("items.$index.file");
                $path = $file->store('designs', 'public');

                $orderItem->designs()->create([
                    'file_path' => $path,
                    'note' => $item['note'], // ✅ gunakan catatan dari user
                    'type' => 'initial',
                ]);
            } else {
                $orderItem->designs()->create([
                    'file_path' => null,
                    'note' => $item['note'], // ✅ walau file tidak diupload, tetap pakai catatan dari user
                    'type' => 'initial',
                ]);
            }
        }

        $snapToken = $midtransService->createTransaction($order);

        return response()->json([
            'snap_token' => $snapToken,
            'order_id' => $order->id,
        ]);
    }

    public function getUserOrders(Request $request)
    {
        $user = auth::user();

        $orders = Order::with([
            'orderItems.product',
            'statusLogs'
        ])
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'List orders berhasil diambil',
            'data' => $orders,
        ]);
    }

    public function getOrderDetail($id)
    {
        $user = auth::user();

        $order = Order::with([
            'orderItems.product',
            'orderItems.designs',
            'statusLogs'
        ])
        ->where('user_id', $user->id)
        ->where('id', $id)
        ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Pesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail pesanan berhasil diambil',
            'data' => $order,
        ]);
    }

}
