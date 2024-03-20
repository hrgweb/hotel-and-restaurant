<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        try {
            $validated = $request->validated();

            $order = Order::create($validated);

            return response()->json($order, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(OrderRequest $request, Order $order)
    {
        try {
            $validated = $request->validated();

            $order->updateOrCreate(['id' => $order->id], $validated);

            return response()->json($validated, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            // Remove old img
            old_img_remove($order->thumbnail);

            $order->delete();
            return response()->json(1, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
