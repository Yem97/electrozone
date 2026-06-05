<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:adminorder-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:update-order-status'],["only" =>["updateStatus"]]);

    }
      public function index()
    {
        $orders = Order::with(['user', 'orderItems.equipment'])->latest()->get();
        return view('adminorders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.equipment'])->findOrFail($id);
        return view('adminorders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
{
    $newStatus = $request->input('status');

    // Valid statuses
    $validStatuses = ['pending', 'paid', 'shipped', 'cancelled'];
    if (!in_array($newStatus, $validStatuses)) {
        return back()->with('error', 'Statut invalide.');
    }

    // Prevent changes if already shipped or cancelled
    if (in_array($order->status, ['shipped', 'cancelled'])) {
        return back()->with('error', 'Commande déjà ' . $order->status . ', modification non autorisée.');
    }

    // Rule: Cannot ship if not paid
    if ($newStatus === 'shipped' && $order->status !== 'paid') {
        return back()->with('error', 'Impossible d\'expédier une commande non payée.');
    }

    // Rule: Cannot cancel if not pending or paid
    if ($newStatus === 'cancelled' && !in_array($order->status, ['pending', 'paid'])) {
        return back()->with('error', 'Impossible d\'annuler cette commande.');
    }

    $order->update(['status' => $newStatus]);

    return back()->with('success', 'Statut mis à jour avec succès.');
}


}
