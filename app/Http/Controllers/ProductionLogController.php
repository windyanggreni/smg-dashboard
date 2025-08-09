<?php

namespace App\Http\Controllers;

use App\Models\ProductionLog;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = ProductionLog::with('stock')->latest()->get();
        return view('dashboard.production_logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stocks = Stock::all();
        return view('dashboard.production_logs.create', compact('stocks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stok_id' => 'required|exists:stocks,id',
            'quantity_used' => 'required|integer|min:1',
        ]);

        $stock = Stock::findOrFail($request->stok_id);

        if ($stock->quantity < $request->quantity_used) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Kurangi stok
        $stock->decrement('quantity', $request->quantity_used);

        // Simpan log
        ProductionLog::create($request->all());

        return redirect()->route('production-logs.index')->with('success', 'Log produksi disimpan & stok dikurangi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductionLog $productionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductionLog $productionLog)
    {
        $stocks = Stock::all();
        return view('dashboard.production_logs.edit', compact('productionLog', 'stocks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductionLog $productionLog)
    {
        $request->validate([
            'stok_id' => 'required|exists:stocks,id',
            'quantity_used' => 'required|integer|min:1',
        ]);

        // Optional: hitung selisih & update stok (lebih kompleks)

        $productionLog->update($request->all());

        return redirect()->route('production-logs.index')->with('success', 'Log produksi diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductionLog $productionLog)
    {
        // Kembalikan stok
        $productionLog->stock->increment('quantity', $productionLog->quantity_used);

        $productionLog->delete();
        return redirect()->route('production-logs.index')->with('success', 'Log dihapus dan stok dikembalikan.');
    }
}
