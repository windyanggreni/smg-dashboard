<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pelanggan (role = customer)
        $totalCustomers = User::where('role', 'pelanggan')->count();

        // Pesanan aktif
        $activeOrders = Order::whereIn('order_status', ['pending', 'processed', 'waiting_approval', 'revision', 'production'])->count();

        // Pesanan selesai bulan ini
        $completedOrdersThisMonth = Order::where('order_status', 'done')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Pendapatan bulan ini (total_price dari order selesai dan payment_status = paid)
        $totalRevenueThisMonth = Order::whereIn('payment_status', ['paid_dp', 'paid_full'])
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_price');

        // Pelanggan terbaru
        // $newCustomers = User::where('role', 'customer')->latest()->take(5)->get();

        // Pesanan terbaru
        $orders = Order::orderBy('created_at', 'desc')->take(10)->get();

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('product')
            ->whereHas('order', function ($q) {
                $q->whereIn('payment_status', ['paid_dp', 'paid_full']) // hanya order yang dibayar
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view(
            'index',
            compact(
                'totalCustomers',
                'activeOrders',
                'completedOrdersThisMonth',
                'totalRevenueThisMonth',
                'orders',
                'topProducts',
            ),
        );
    }
}
