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

    // Tambahkan method create untuk menampilkan form pembuatan Order
    public function create()
    {
        $services = Service::orderBy('service_name')->get(['service_id', 'service_name', 'price']);
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

        \DB::transaction(function () use ($data) {
            $order = new Order();
            $order->order_code = 'ORD-'.strtoupper(Str::random(6));
            $order->customer_name = $data['customer_name'];
            $order->customer_whatsapp = $data['customer_whatsapp'];
            $order->status = $data['status'];
            $order->total_amount = collect($data['items'])->sum('price_at_order');
            // Keep dashboard-friendly single service_id (first item) if column exists
            if (\Illuminate\Support\Facades\Schema::hasColumn($order->getTable(), 'service_id')) {
                $order->service_id = $data['items'][0]['service_id'] ?? null;
            }
            $order->save();

            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->order_id,
                    'service_id' => $item['service_id'],
                    'price_at_order' => $item['price_at_order'],
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order created');
    }

    // Tambahkan method edit untuk menampilkan form edit Order
    public function edit(Order $order)
    {
        $order->load('items');
        $services = Service::orderBy('service_name')->get(['service_id', 'service_name', 'price']);
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
        \DB::transaction(function () use ($data, $order) {
            $order->customer_name = $data['customer_name'];
            $order->customer_whatsapp = $data['customer_whatsapp'];
            $order->status = $data['status'];
            $order->total_amount = collect($data['items'])->sum('price_at_order');
            if (\Illuminate\Support\Facades\Schema::hasColumn($order->getTable(), 'service_id')) {
                $order->service_id = $data['items'][0]['service_id'] ?? $order->service_id;
            }
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
        });

        return redirect()->route('orders.index')->with('success', 'Order updated');
    }

    public function show(Order $order)
    {
        $order->load(['items.service', 'invoices']);
        return view('orders.show', compact('order'));
    }
}