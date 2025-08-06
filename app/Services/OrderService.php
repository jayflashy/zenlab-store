<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Auth;
use DB;
use Exception;
use Str;

class OrderService
{
    /**
     * Create a new order from cart items
     *
     * @return Order
     */
    public function createOrder(array $orderData, Cart $cart)
    {
        try {
            DB::beginTransaction();

            // Handle guest user if needed
            $userId = Auth::id();
            if (! $userId && isset($orderData['email']) && isset($orderData['name'])) {
                $user = $this->createOrGetUser($orderData['name'], $orderData['email']);
                $userId = $user->id;
            }

            // Create the order
            $order = Order::create([
                'user_id' => $userId,
                'email' => $orderData['email'],
                'name' => $orderData['name'],
                'code' => getTrx(8),
                'subtotal' => $orderData['subtotal'],
                'discount' => $orderData['discount'] ?? 0,
                'total' => $orderData['total'],
                'payment_method' => $orderData['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'cart_id' => $cart->id,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'license_type' => $item->license_type,
                    'extended_support' => $item->extended_support,
                    'support_price' => $item->support_price,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

    /**
     * Mark an order as complete
     *
     * @return Order
     */
    public function completeOrder(Order $order, array $paymentData = [])
    {
        $order->payment_status = 'completed';
        $order->order_status = 'completed';
        $order->response = ($paymentData);
        $order->payment_date = now();
        $order->save();
        // increase sales for each order items
        foreach ($order->items()->with('product')->get() as $item) {
            //generate license code for order item
            $licenseCode = Str::uuid();
            $extended = $item->extended_support;
            if ($item->license_type == 'regular') {
                $supportPeriod = 3;
            } else {
                $supportPeriod = 6;
            }
            if ($extended) {
                $supportPeriod *= 2;
            }
            $item->update([
                'license_code' => $licenseCode,
                'support_end_date' => now()->addMonths($supportPeriod),
            ]);

            // update item product sales count
            $item->product->update(['sales_count' => $item->product->sales_count + $item->quantity]);
        }


        // Clear the cart after successful order
        if ($order->cart_id) {
            Cart::where('id', $order->cart_id)->delete();
        }

        // send email and other notification

        return $order;
    }

    /**
     * Mark an order as failed
     *
     * @return Order
     */
    public function failOrder(Order $order, array $paymentData = [])
    {
        $order->payment_status = 'failed';
        $order->order_status = 'failed';
        $order->response = ($paymentData);
        $order->save();

        return $order;
    }

    /**
     * Handle manual payment (bank transfer)
     *
     * @return Order
     */
    public function processManualPayment(Order $order, string $receiptPath, string $reference)
    {
        $order->payment_receipt = $receiptPath;
        $order->bank_reference = $reference;
        $order->payment_status = 'pending';
        $order->order_status = 'processing';
        $order->notes = 'Manual payment receipt uploaded. Reference: ' . $reference;
        $order->save();

        // Clear cart but don't mark as completed yet
        if ($order->cart_id) {
            Cart::where('id', $order->cart_id)->delete();
        }

        return $order;
    }

    /**
     * Create or get user from email
     *
     * @return User
     */
    protected function createOrGetUser(string $name, string $email)
    {
        return User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => bcrypt(getTrx(18)),
                'status' => 'active',
                'username' => User::generateUniqueUsername(text_trimer($name,19)),
            ]
        );
    }
}
