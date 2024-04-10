<?php

namespace App\Http\Controllers;

use Exception;
use App\OrderStatus;
use App\PaymentType;
use App\TableStatus;
use App\Models\Order;
use App\Models\Table;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validated();
            $validated['payment_type'] = PaymentType::CASH;

            $amount = $validated['amount'];
            $total = $validated['total'];
            if ($validated['amount'] < $validated['total']) {
                throw new Exception('Amount must not lower than total');
            }

            $validated['change'] = $amount - $total;

            // Payment made
            $payment = Payment::create($validated);

            // Table update label to availabe
            Table::where('id', $validated['table_id'])->update(['status' => TableStatus::AVAILABLE]);

            // Order update label to paid
            Order::where('id', $validated['order_id'])->update(['status' => 'paid']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
        DB::commit();
        return response()->json($payment, 201);
    }
}
