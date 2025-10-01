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
        public array|string $to,
        public string $message,
        public ?string $ctaUrl = null,
        public array $templateVars = [],
    ) {}

    public function handle(): void
    {
        $targets = $this->normalizeTargets($this->to);
        if (empty($targets)) {
            Log::warning('No valid WhatsApp targets provided');
            return;
        }

        // Provider: Fonnte (preferred if configured)
        // Prefer runtime config first (local Settings), fallback to env
        $fonnteToken = config('services.fonnte.token') ?: env('FONNTE_TOKEN');

        if ($fonnteToken) {
            try {
                $payload = [
                    // Fonnte expects international format without +, multiple targets separated by comma
                    'target' => implode(',', $targets),
                    'message' => $this->message . ($this->ctaUrl ? "\n\n".$this->ctaUrl : ''),
                ];

                $resp = Http::asForm()
                    ->withHeaders(['Authorization' => $fonnteToken])
                    ->post('https://api.fonnte.com/send', $payload);

                if ($resp->successful()) {
                    Log::info('Fonnte WA sent', ['to' => $targets]);
                    return;
                }

                Log::warning('Fonnte API failed', [
                    'to' => $targets,
                    'status' => $resp->status(),
                    'body' => $resp->body(),
                ]);
            } catch (\Throwable $e) {
                Log::error('Fonnte API error: '.$e->getMessage());
            }
            // If Fonnte configured but failed, continue to next fallback
        }

        // WhatsApp Cloud API configs (prefer runtime config first)
        $token = config('services.whatsapp.cloud.token') ?: env('WHATSAPP_CLOUD_TOKEN');
        $fromPhoneId = config('services.whatsapp.cloud.phone_id') ?: env('WHATSAPP_CLOUD_PHONE_ID'); // e.g. 123456789012345
        $graphVersion = config('services.whatsapp.cloud.graph_version', env('WHATSAPP_CLOUD_GRAPH_VERSION', 'v20.0'));
        $templateName = config('services.whatsapp.cloud.template_name') ?: env('WHATSAPP_TEMPLATE_NAME'); // optional
        $templateLang = config('services.whatsapp.cloud.template_lang', env('WHATSAPP_TEMPLATE_LANG', 'id')); // optional

        if ($token && $fromPhoneId) {
            try {
                foreach ($targets as $phone) {
                    $payload = [
                        'messaging_product' => 'whatsapp',
                        'to' => $phone,
                    ];

                    if (!empty($templateName)) {
                        // Build template payload
                        $components = [];
                        $bodyParams = [];
                        // Map up to 10 vars if provided
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
                }
                return;
            } catch (\Throwable $e) {
                Log::error('WhatsApp API error: '.$e->getMessage());
            }
        }

        // Fallback: just log wa.me link so admin can manually follow up
        if (!$fonnteToken && !$token && !$fromPhoneId) {
            Log::warning('No WhatsApp provider configured (Fonnte or Cloud API). Falling back to wa.me link.');
        }
        $extra = $this->ctaUrl ? ("\n\n".$this->ctaUrl) : '';
        foreach ($targets as $phone) {
            $waLink = 'https://wa.me/'.$phone.'?text='.rawurlencode($this->message.$extra);
            Log::info('WhatsApp fallback link', ['link' => $waLink]);
        }
    }

    private function normalizeTargets(array|string $raw): array
    {
        $list = is_array($raw) ? $raw : [$raw];
        $res = [];
        foreach ($list as $entry) {
            $digits = preg_replace('/\D/', '', (string) $entry);
            if ($digits === '') continue;
            if (str_starts_with($digits, '0')) {
                $digits = '62'.substr($digits, 1);
            }
            $res[] = $digits;
        }
        // Remove duplicates and reindex
        $res = array_values(array_unique($res));
        return $res;
    }
}
