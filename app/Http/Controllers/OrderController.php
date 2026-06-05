<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:order-list'],["only" =>["index","show"]]);

    }
    /**
     * Display a listing of the user's orders.
     */
   public function index(Request $request)
{
    $status = $request->query('status');

    $orders = auth()->user()->orders()
        ->when($status, fn($q) => $q->where('status', $status))
        ->with('items.equipment')
        ->latest()
        ->get();

    return view('orders.index', compact('orders'));
}


    /**
     * Display the specified order with items and equipment.
     */
    public function show(string $id)
    {
        $order = Order::with('items.equipment')
                      ->where('user_id', Auth::id())
                      ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for creating a new resource (not used here).
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage (not used here).
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource (not used here).
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage (not used here).
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage (not used here).
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
