<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        if ($product->zaiko < $request->quantity) {
            return response()->json(['error' => '在庫が不足しています'], 400);
        }

        DB::beginTransaction();

        try {
            Sale::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'purchased_at' => now(),
            ]);

            $product->zaiko -= $request->quantity;
            $product->save();

            DB::commit();

            return response()->json(['message' => '購入完了しました'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => '購入処理に失敗しました'], 500);
        }
    }
}
