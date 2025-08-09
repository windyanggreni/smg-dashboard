<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        $products = Product::all();
        $categories = Category::orderBy('name')->get();

        return view('dashboard.laporan.index', compact('orders', 'products', 'categories'));
    }

    public function cetakTransaksiPdf(Request $request)
    {
        $query = Order::with('user');

        // Kalau sertakan detail item, load relasi items & product
        $includeItems = $request->boolean('include_items');

        if ($includeItems) {
            $query->with(['user', 'orderItems.product']);
        } else {
            $query->with('user');
        }

        // Filter tanggal
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [Carbon::parse($request->start_date)->startOfDay(), Carbon::parse($request->end_date)->endOfDay()]);
        }

        // Filter status order
        if ($request->filled('status')) {
            $status = is_array($request->status) ? $request->status : [$request->status];
            $query->whereIn('order_status', $status);
        }

        // Filter status pembayaran
        if ($request->filled('payment_status')) {
            $paymentStatus = is_array($request->payment_status) ? $request->payment_status : [$request->payment_status];
            $query->whereIn('payment_status', $paymentStatus);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        $sortOptions = [
            'oldest' => ['created_at', 'asc'],
            'highest_price' => ['total_price', 'desc'],
            'lowest_price' => ['total_price', 'asc'],
            'latest' => ['created_at', 'desc'],
        ];
        $query->orderBy(...$sortOptions[$sort] ?? $sortOptions['latest']);

        $orders = $query->get();

        // Label filter
        $statusLabel = $request->filled('status') ? implode(', ', array_map(fn($s) => ucfirst(str_replace('_', ' ', $s)), (array) $request->status)) : null;

        $paymentStatusLabel = $request->filled('payment_status') ? implode(', ', array_map(fn($p) => ucfirst(str_replace('_', ' ', $p)), (array) $request->payment_status)) : null;

        $sortLabelMap = [
            'latest' => 'Terbaru',
            'oldest' => 'Terlama',
            'highest_price' => 'Harga Tertinggi',
            'lowest_price' => 'Harga Terendah',
        ];
        $sortLabel = $sortLabelMap[$sort] ?? 'Terbaru';

        $totalHarga = $orders->sum('total_price');
        $jumlahOrder = $orders->count();

        $pdf = Pdf::loadView('dashboard.laporan.transaksi.cetak-transaksi', [
            'orders' => $orders,
            'startDateLabel' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d-m-Y') : null,
            'endDateLabel' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d-m-Y') : null,
            'statusLabel' => $statusLabel,
            'paymentStatusLabel' => $paymentStatusLabel,
            'sortLabel' => $sortLabel,
            'totalHarga' => $totalHarga,
            'jumlahOrder' => $jumlahOrder,
            'includeItems' => $includeItems,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-transaksi.pdf');
    }

    public function stokIndex()
    {
        $categories = Category::orderBy('name')->get();

        return view('dashboard.laporan.stok.index', compact('categories'));
    }

    public function cetakStokPdf(Request $request)
    {
        $query = Product::with('category');

        // Filter multiple kategori
        if ($request->filled('category_id')) {
            $categoryIds = is_array($request->category_id) ? $request->category_id : [$request->category_id];
            $query->whereIn('category_id', $categoryIds);
        }

        // Filter sorting
        $sort = $request->get('sort', 'name');
        if ($sort === 'stock_desc') {
            $query->orderBy('stock_barang', 'desc');
        } elseif ($sort === 'stock_asc') {
            $query->orderBy('stock_barang', 'asc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();

        // Label kategori utk header laporan
        $categoryLabel = null;
        if ($request->filled('category_id')) {
            $categoryLabel = Category::whereIn('id', $categoryIds)->pluck('name')->implode(', ');
        }

        $pdf = Pdf::loadView('dashboard.laporan.stok.cetak-stok', [
            'products' => $products,
            'categoryLabel' => $categoryLabel,
            'sortLabel' => match ($sort) {
                'stock_desc' => 'Stok Terbanyak',
                'stock_asc' => 'Stok Tersedikit',
                default => 'Nama Produk (A-Z)',
            },
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-stok.pdf');
    }

    public function performaIndex()
    {
        $categories = Category::orderBy('name')->get();
        return view('dashboard.laporan.performa.index', compact('categories'));
    }

    public function cetakPerformaPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $categoryIds = $request->input('category_id', []);
        $sort = $request->input('sort', 'terlaris');
        $showAll = $request->boolean('show_all_products', false);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        // Subquery untuk total penjualan per produk di rentang tanggal dan status done
        $salesSubquery = DB::table('order_items')
            ->join('orders', function ($join) use ($startDate, $endDate) {
                $join
                    ->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.order_status', 'done')
                    ->whereBetween('orders.created_at', [$startDate, $endDate]);
            })
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_omzet'))
            ->groupBy('order_items.product_id');

        $query = DB::table('products')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoinSub($salesSubquery, 'sales', function ($join) {
                $join->on('products.id', '=', 'sales.product_id');
            })
            ->select('products.id', 'products.name', 'categories.name as category_name', DB::raw('COALESCE(sales.total_qty, 0) as total_qty'), DB::raw('COALESCE(sales.total_omzet, 0) as total_omzet'));

        if (!empty($categoryIds)) {
            $query->whereIn('products.category_id', $categoryIds);
        }

        if (!$showAll) {
            $query->havingRaw('total_qty > 0');
        }

        // Sorting
        if ($sort === 'terlaris') {
            $query->orderByDesc('total_qty');
        } elseif ($sort === 'omzet') {
            $query->orderByDesc('total_omzet');
        } elseif ($sort === 'paling_jarang') {
            $query->orderBy('total_qty');
        } else {
            $query->orderBy('products.name');
        }

        $results = $query->get();

        $categoryLabel = !empty($categoryIds) ? implode(', ', Category::whereIn('id', $categoryIds)->pluck('name')->toArray()) : 'Semua Kategori';

        $pdf = Pdf::loadView('dashboard.laporan.performa.cetak-performa', [
            'results' => $results,
            'categoryLabel' => $categoryLabel,
            'startDateLabel' => $startDate->format('d-m-Y'),
            'endDateLabel' => $endDate->format('d-m-Y'),
            'sortLabel' => match ($sort) {
                'terlaris' => 'Produk Terlaris',
                'omzet' => 'Omzet Tertinggi',
                'paling_jarang' => 'Produk Paling Jarang',
                default => 'Urutan Default',
            },
            'showAll' => $showAll,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-performa-penjualan.pdf');
    }
}
