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
            $orders = $request->input('orders');
            $table = $request->input('table');

            // If no orders throw error
            if (count($orders) <= 0) {
                throw new Exception('Please have an order.');
            }

            $result = [];

            $refNo = generate_reference_no();
            foreach ($orders as $order) {
                $product = $order['product'];

                $order = Order::create([
                    'reference_no' => $refNo,
                    'product_id' => $product['id'],
                    'table_id' => $table['id'],
                    'product_name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => $order['qty'],
                    'subtotal' => $product['price'] * $order['qty']
                ]);

                array_push($result, $order);
            }

            return response()->json($result, 201);
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
