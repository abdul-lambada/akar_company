<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::withCount('items')->orderByDesc('order_id')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $services = Service::orderBy('service_name')->get();
        return view('orders.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:30',
            'status' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|integer|exists:services,service_id',
            'items.*.price_at_order' => 'required|numeric|min:0',
        ]);

        $order = new Order();
        $order->order_code = 'ORD-'.strtoupper(Str::random(6));
        $order->customer_name = $data['customer_name'];
        $order->customer_whatsapp = $data['customer_whatsapp'];
        $order->status = $data['status'];
        $order->total_amount = collect($data['items'])->sum('price_at_order');
        $order->save();

        foreach ($data['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'service_id' => $item['service_id'],
                'price_at_order' => $item['price_at_order'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created');
    }

    public function edit(Order $order)
    {
        $order->load('items');
        $services = Service::orderBy('service_name')->get();
        return view('orders.edit', compact('order', 'services'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_whatsapp' => 'required|string|max:30',
            'status' => 'required|string|max:50',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|integer|exists:services,service_id',
            'items.*.price_at_order' => 'required|numeric|min:0',
        ]);

        $order->customer_name = $data['customer_name'];
        $order->customer_whatsapp = $data['customer_whatsapp'];
        $order->status = $data['status'];
        $order->total_amount = collect($data['items'])->sum('price_at_order');
        $order->save();

        // reset items
        $order->items()->delete();
        foreach ($data['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'service_id' => $item['service_id'],
                'price_at_order' => $item['price_at_order'],
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order updated');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted');
    }
}