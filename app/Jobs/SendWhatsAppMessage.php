<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $to,
        public string $message,
        public ?string $ctaUrl = null,
        public array $templateVars = [],
    ) {}

    public function handle(): void
    {
        $phone = $this->normalizePhone($this->to);

        // Provider: Fonnte (preferred if configured)
        // Prefer env (production), but allow config override (local)
        $fonnteToken = env('FONNTE_TOKEN') ?: config('services.fonnte.token');

        if ($fonnteToken) {
            try {
                $payload = [
                    // Fonnte expects international format without +, multiple targets separated by comma
                    'target' => $phone,
                    'message' => $this->message . ($this->ctaUrl ? "\n\n".$this->ctaUrl : ''),
                ];

                $resp = Http::asForm()
                    ->withHeaders(['Authorization' => $fonnteToken])
                    ->post('https://api.fonnte.com/send', $payload);

                if ($resp->successful()) {
                    Log::info('Fonnte WA sent', ['to' => $phone]);
                    return;
                }

                Log::warning('Fonnte API failed', [
                    'to' => $phone,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Fonnte API error: '.$e->getMessage());
            }
            // If Fonnte configured but failed, continue to next fallback
        }

        // WhatsApp Cloud API configs (env with config fallback)
        $token = env('WHATSAPP_CLOUD_TOKEN') ?: config('services.whatsapp.cloud.token');
        $fromPhoneId = env('WHATSAPP_CLOUD_PHONE_ID') ?: config('services.whatsapp.cloud.phone_id'); // e.g. 123456789012345
        $graphVersion = env('WHATSAPP_CLOUD_GRAPH_VERSION', config('services.whatsapp.cloud.graph_version', 'v20.0'));
        $templateName = env('WHATSAPP_TEMPLATE_NAME') ?: config('services.whatsapp.cloud.template_name'); // optional
        $templateLang = env('WHATSAPP_TEMPLATE_LANG', config('services.whatsapp.cloud.template_lang', 'id')); // optional

        if ($token && $fromPhoneId) {
            try {
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $phone,
                ];

                if (!empty($templateName)) {
                    // Build template payload
                    $components = [];
                    $bodyParams = [];
                    // Map up to 5 vars if provided
                    foreach (array_values($this->templateVars) as $idx => $val) {
                        if ($idx >= 10) break; // guard
                        $bodyParams[] = [ 'type' => 'text', 'text' => (string) $val ];
                    }
                    if (!empty($bodyParams)) {
                        $components[] = [
                            'type' => 'body',
                            'parameters' => $bodyParams,
                        ];
                    }
                    // Optional button URL param if template supports it
                    if (!empty($this->ctaUrl)) {
                        $components[] = [
                            'type' => 'button',
                            'sub_type' => 'url',
                            'index' => '0',
                            'parameters' => [ [ 'type' => 'text', 'text' => $this->ctaUrl ] ],
                        ];
                    }

                    $payload['type'] = 'template';
                    $payload['template'] = [
                        'name' => $templateName,
                        'language' => [ 'code' => $templateLang ],
                        'components' => $components,
                    ];
                } else {
                    // Fallback to plain text
                    $payload['type'] = 'text';
                    $payload['text'] = [ 'body' => $this->message ];
                }

                $resp = Http::withToken($token)
                    ->acceptJson()
                    ->post("https://graph.facebook.com/{$graphVersion}/{$fromPhoneId}/messages", $payload);

                if ($resp->successful()) {
                    Log::info('WhatsApp message sent', ['to' => $phone]);
                } else {
                    Log::warning('WhatsApp API failed', [
                        'to' => $phone,
                        'status' => $resp->status(),
                        'body' => $resp->body(),
                    ]);
                }
                return;
            } catch (\Throwable $e) {
                Log::error('WhatsApp API error: '.$e->getMessage());
            }
        }

        // Fallback: just log wa.me link so admin can manually follow up
        $extra = $this->ctaUrl ? ("\n\n".$this->ctaUrl) : '';
        $waLink = 'https://wa.me/'.$phone.'?text='.rawurlencode($this->message.$extra);
        Log::info('WhatsApp fallback link', ['link' => $waLink]);
    }

    private function normalizePhone(string $raw): string
    {
        $digits = preg_replace('/\D/', '', $raw);
        if ($digits === '') return $digits;
        if (str_starts_with($digits, '0')) {
            return '62'.substr($digits, 1);
        }
        return $digits;
    }
}
