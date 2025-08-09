<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        $orders = $query->get();

        return view('dashboard.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product', 'OrderItems.designs', 'statusLogs.changedBy'])->findOrFail($id);
        return view('dashboard.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,waiting_approval,revision,production,done,canceled',
            'note' => 'nullable|string',
        ]);

        $order = Order::findOrFail($id);
        $order->order_status = $request->status;
        $order->save();

        OrderStatusLog::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'note' => $request->note,
            'changed_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Status order diperbarui.');
    }

    public function uploadRevision(Request $request, $orderItemId)
    {
        $request->validate([
            'design_file' => 'required|file|mimes:pdf,jpg,jpeg,png,svg',
            'note' => 'nullable|string',
            'type' => 'nullable|in:initial,revision',
        ]);

        $file = $request->file('design_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('designs', $filename, 'public');

        $orderItem = OrderItem::findOrFail($orderItemId);

        $type = $request->input('type') ?? (
            $orderItem->designs()->count() === 0 ? 'initial' : 'revision'
        );

        Design::create([
            'order_item_id' => $orderItemId,
            'file_path' => $path,
            'type' => $type,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Desain berhasil diunggah.');
    }
}
