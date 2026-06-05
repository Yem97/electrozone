<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmation;
use App\Mail\AdminOrderNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Remove permission middleware for checkout - let routes handle auth
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            DB::beginTransaction();

            // Calculate total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Split customer_name into first_name and last_name
            $nameParts = explode(' ', trim($validated['full_name']), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['full_name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'],
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $validated['address'],
            ]);

            // Create order items
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'equipment_id' => $id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            // Load the order with its items and equipment relationships
            $order->load('items.equipment');

            // Send email to customer
            try {
                $paymentLink = route('orders.show', $order->id); // You can customize this link
                Mail::to($validated['email'])->send(new OrderConfirmation($order, $paymentLink));
                Log::info('Order confirmation email sent to customer: ' . $validated['email']);
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Send email to admin
            try {
                $adminEmail = config('mail.admin_email', 'admin@example.com'); // Set this in your config
                Mail::to($adminEmail)->send(new AdminOrderNotification($order));
                Log::info('Admin notification email sent to: ' . $adminEmail);
            } catch (\Exception $e) {
                Log::error('Failed to send admin notification email: ' . $e->getMessage());
            }

            // Clear the cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('checkout.thankyou')->with('success', 'Order placed successfully! Check your email for confirmation.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout process failed: ' . $e->getMessage(), [
                'exception' => $e,
                'cart' => $cart,
                'validated_data' => $validated,
                'stack_trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->with('error', 'There was an error processing your order. Error: ' . $e->getMessage());
        }
    }

    public function thankYou()
    {
        return view('checkout.thankyou');
    }
}