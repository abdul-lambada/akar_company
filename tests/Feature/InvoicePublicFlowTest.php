<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class InvoicePublicFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Ensure factories are loaded; migrations will run automatically via RefreshDatabase
    }

    public function test_signed_status_page_renders_ok()
    {
        $client = Client::query()->create([
            'client_name' => 'Test Client',
            'email' => 'client@example.com',
            'whatsapp' => '08123456789',
            'address' => 'Jl. Test 123',
        ]);

        $invoice = Invoice::factory()->create([
            'client_id' => $client->getKey(),
            'status' => 'sent',
            'total_amount' => 150000,
        ]);

        InvoiceItem::factory()->create([
            'invoice_id' => $invoice->getKey(),
            'description' => 'Service A',
            'quantity' => 1,
            'unit_price' => 150000,
            'line_total' => 150000,
        ]);

        $url = URL::signedRoute('invoices.public.status', ['invoice' => $invoice->getKey()]);
        $resp = $this->get($url);
        $resp->assertOk();
        $resp->assertSee('Status Pembayaran');
        $resp->assertSee($invoice->invoice_code);
    }

    public function test_confirm_paid_updates_invoice_status()
    {
        $client = Client::query()->create([
            'client_name' => 'Test B',
            'email' => 'b@example.com',
            'whatsapp' => '0811111111',
            'address' => 'Alamat',
        ]);
        $invoice = Invoice::factory()->create([
            'client_id' => $client->getKey(),
            'status' => 'sent',
            'total_amount' => 50000,
        ]);

        $url = URL::signedRoute('invoices.public.paid', ['invoice' => $invoice->getKey()]);
        $resp = $this->post($url, [
            // CSRF token is not required in tests; framework fakes it
        ]);

        $resp->assertRedirect();
        $this->assertDatabaseHas('invoices', [
            'invoice_id' => $invoice->getKey(),
            'status' => 'paid',
        ]);
    }

    public function test_admin_can_download_invoice_pdf()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $client = Client::query()->create([
            'client_name' => 'Admin PDF Client',
            'email' => 'adminpdf@example.com',
            'whatsapp' => '0813333333',
            'address' => 'Alamat',
        ]);
        $invoice = Invoice::factory()->create([
            'client_id' => $client->getKey(),
            'status' => 'sent',
            'total_amount' => 75000,
        ]);

        $this->actingAs($admin);
        $resp = $this->get('/admin/invoices/'.$invoice->getKey().'/pdf');

        // Depending on dompdf/barryvdh presence, we either get application/pdf or an HTML fallback
        $resp->assertSuccessful();
        $contentType = $resp->headers->get('Content-Type');
        $this->assertTrue(
            $contentType === 'application/pdf' || str_contains((string)$contentType, 'text/html'),
            'Unexpected content type: '.$contentType
        );
    }
}
