<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('client')->orderByDesc('invoice_id')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        $clients = Client::orderBy('client_name')->get();
        return view('invoices.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|integer|exists:clients,client_id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $invoice = new Invoice($data);
        $invoice->invoice_code = 'INV-'.strtoupper(Str::random(6));
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice created');
    }

    public function edit(Invoice $invoice)
    {
        $clients = Client::orderBy('client_name')->get();
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'client_id' => 'required|integer|exists:clients,client_id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $invoice->update($data);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client','order']);
        return view('invoices.show', compact('invoice'));
    }
}