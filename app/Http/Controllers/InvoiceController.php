<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
// Email flow removed; using WhatsApp only

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
        $invoice->load(['client','order','items']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Signed public endpoint to download invoice PDF without authentication.
     */
    public function publicPdf(Invoice $invoice)
    {
        $invoice->load(['client','order','items']);

        $filename = 'Invoice-'.$invoice->invoice_code.'.pdf';

        // Use barryvdh facade if available
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', compact('invoice'));
            return $pdf->download($filename);
        }

        // Fallback to native dompdf if installed
        if (class_exists(\Dompdf\Dompdf::class)) {
            $html = view('invoices.pdf', ['invoice' => $invoice])->render();
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $output = $dompdf->output();
            return response($output)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        }

        // Last resort: HTML preview
        return response()->view('invoices.pdf', compact('invoice'))->withHeaders([
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Admin download endpoint (requires auth via route group), mirrors publicPdf without signed middleware.
     */
    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['client','order','items']);

        $filename = 'Invoice-'.$invoice->invoice_code.'.pdf';

        // Use barryvdh facade if available
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('invoices.pdf', compact('invoice'));
            return $pdf->download($filename);
        }

        // Fallback to native dompdf if installed
        if (class_exists(\Dompdf\Dompdf::class)) {
            $html = view('invoices.pdf', ['invoice' => $invoice])->render();
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4');
            $dompdf->render();
            $output = $dompdf->output();
            return response($output)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
        }

        // Last resort: HTML preview
        return response()->view('invoices.pdf', compact('invoice'))->withHeaders([
            'Content-Type' => 'application/pdf',
        ]);
    }
}