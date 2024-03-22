<?php

namespace App\Http\Controllers;

use Exception;
use App\OrderStatus;
use App\TableStatus;
use App\Models\Order;
use App\Models\Table;
use App\Models\OrderItem;
use App\Services\OrderService;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        try {
            $orderItems = $request->input('orderItems');
            $table = $request->input('table');

            // If no order items throw error
            if (count($orderItems) <= 0) {
                throw new Exception('Please have an order.');
            }

            $list = [];

            // Save order
            $order = Order::create([
                'table_id' => $table['id'],
                'reference_no' => generate_reference_no(),
                'total' => OrderService::total($orderItems),
                'type' => $request->input('type'),
                'status' => OrderStatus::PENDING
            ]);

            // Save order items
            foreach ($orderItems as $item) {
                $product = $item['product'];

                $item = OrderItem::create([
                    'order_id' => $order?->id,
                    'product_id' => $product['id'],
                    'product_name' => $product['name'],
                    'price' => $product['price'],
                    'qty' => $item['qty'],
                    'subTotal' => $product['price'] * $item['qty']
                ]);

                array_push($list, $item);
            }

            // Update table status
            Table::where('id', $table['id'])->update(['status' => TableStatus::OCCUPIED]);

            return response()->json([
                'order' => $order,
                'orderItems' => $list
            ], 201);
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
