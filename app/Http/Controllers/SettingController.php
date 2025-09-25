<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Jobs\SendWhatsAppMessage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'mail_from_address' => config('mail.from.address'),
            'app_url' => config('app.url'),
            'app_locale' => config('app.locale'),
            'app_timezone' => config('app.timezone'),
            'app_logo' => config('app.logo'),
            'app_currency' => config('app.currency'),
            'app_date_format' => config('app.date_format'),
            // additional configurable fields
            'company_whatsapp' => config('app.company_whatsapp'),
            'fonnte_token' => env('FONNTE_TOKEN'),
            'wa_template_name' => env('WHATSAPP_TEMPLATE_NAME'),
            'wa_template_lang' => env('WHATSAPP_TEMPLATE_LANG', 'id'),
            'hero_heading' => config('app.hero_heading'),
            'hero_description' => config('app.hero_description'),
            'services_heading' => config('app.services_heading'),
            'services_description' => config('app.services_description'),
            'portfolio_heading' => config('app.portfolio_heading'),
            'portfolio_description' => config('app.portfolio_description'),
            'testimonials_heading' => config('app.testimonials_heading'),
            'testimonials_description' => config('app.testimonials_description'),
            'contact_cta_title' => config('app.contact_cta_title'),
            'contact_cta_description' => config('app.contact_cta_description'),
        ];
        // Merge local overrides if in local and file exists
        if (app()->environment('local')) {
            $over = $this->loadLocalSettings();
            if (!empty($over)) {
                $settings = array_merge($settings, array_intersect_key($over, $settings + [
                    'fonnte_token' => true,
                    'wa_template_name' => true,
                    'wa_template_lang' => true,
                ]));
                // Additional keys not in config(app.*)
                $settings['fonnte_token'] = $over['fonnte_token'] ?? $settings['fonnte_token'];
                $settings['wa_template_name'] = $over['wa_template_name'] ?? $settings['wa_template_name'];
                $settings['wa_template_lang'] = $over['wa_template_lang'] ?? $settings['wa_template_lang'];
                $settings['company_whatsapp'] = $over['company_whatsapp'] ?? $settings['company_whatsapp'];
            }
        }
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'app_name' => 'required|string|max:255',
            'mail_from_address' => 'nullable|email|max:255',
            'app_url' => 'required|url|max:255',
            'app_locale' => 'required|string|max:12',
            'app_timezone' => 'required|string|max:50',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:4096',
            'app_currency' => 'nullable|string|max:10',
            'app_date_format' => 'nullable|string|max:20',
            // new configurable fields
            'company_whatsapp' => 'nullable|string|max:32',
            'fonnte_token' => 'nullable|string|max:255',
            'wa_template_name' => 'nullable|string|max:80',
            'wa_template_lang' => 'nullable|string|max:10',
            'hero_heading' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string|max:500',
            'services_heading' => 'nullable|string|max:255',
            'services_description' => 'nullable|string|max:255',
            'portfolio_heading' => 'nullable|string|max:255',
            'portfolio_description' => 'nullable|string|max:255',
            'testimonials_heading' => 'nullable|string|max:255',
            'testimonials_description' => 'nullable|string|max:255',
            'contact_cta_title' => 'nullable|string|max:255',
            'contact_cta_description' => 'nullable|string|max:500',
        ]);

        // handle logo upload
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('logos', 'public');
            $data['app_logo'] = $path;
        } else {
            $data['app_logo'] = config('app.logo');
        }

        if (app()->environment('production')) {
            $this->setEnv([
            'APP_NAME' => '"' . $data['app_name'] . '"',
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'] ?? '',
            'APP_URL' => $data['app_url'],
            'APP_LOCALE' => $data['app_locale'],
            'APP_TIMEZONE' => $data['app_timezone'],
            'APP_LOGO' => '"' . ($data['app_logo'] ?? '') . '"',
            'APP_CURRENCY' => $data['app_currency'] ?? 'USD',
            'APP_DATE_FORMAT' => $data['app_date_format'] ?? 'Y-m-d',
            // front texts & whatsapp
            'COMPANY_WHATSAPP' => '"' . preg_replace('/\D/', '', ($data['company_whatsapp'] ?? '')) . '"',
            'APP_WHATSAPP_NUMBER' => '"' . preg_replace('/\D/', '', ($data['company_whatsapp'] ?? '')) . '"',
            // WA providers settings
            'FONNTE_TOKEN' => '"' . ($data['fonnte_token'] ?? '') . '"',
            'WHATSAPP_TEMPLATE_NAME' => '"' . ($data['wa_template_name'] ?? '') . '"',
            'WHATSAPP_TEMPLATE_LANG' => '"' . ($data['wa_template_lang'] ?? 'id') . '"',
            'HERO_HEADING' => '"' . ($data['hero_heading'] ?? config('app.hero_heading')) . '"',
            'HERO_DESCRIPTION' => '"' . ($data['hero_description'] ?? config('app.hero_description')) . '"',
            'SERVICES_HEADING' => '"' . ($data['services_heading'] ?? config('app.services_heading')) . '"',
            'SERVICES_DESCRIPTION' => '"' . ($data['services_description'] ?? config('app.services_description')) . '"',
            'PORTFOLIO_HEADING' => '"' . ($data['portfolio_heading'] ?? config('app.portfolio_heading')) . '"',
            'PORTFOLIO_DESCRIPTION' => '"' . ($data['portfolio_description'] ?? config('app.portfolio_description')) . '"',
            'TESTIMONIALS_HEADING' => '"' . ($data['testimonials_heading'] ?? config('app.testimonials_heading')) . '"',
            'TESTIMONIALS_DESCRIPTION' => '"' . ($data['testimonials_description'] ?? config('app.testimonials_description')) . '"',
            'CONTACT_CTA_TITLE' => '"' . ($data['contact_cta_title'] ?? config('app.contact_cta_title')) . '"',
            'CONTACT_CTA_DESCRIPTION' => '"' . ($data['contact_cta_description'] ?? config('app.contact_cta_description')) . '"',
            ]);

            try {
                // refresh config cache so changes take effect
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
            } catch (\Throwable $e) {
                // ignore
            }

            return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
        } else {
            // LOCAL: persist to storage JSON and set config at runtime (avoid .env write & server restart)
            $payload = [
                'app_name' => $data['app_name'],
                'mail_from_address' => $data['mail_from_address'] ?? null,
                'app_url' => $data['app_url'],
                'app_locale' => $data['app_locale'],
                'app_timezone' => $data['app_timezone'],
                'app_logo' => $data['app_logo'] ?? null,
                'app_currency' => $data['app_currency'] ?? null,
                'app_date_format' => $data['app_date_format'] ?? null,
                'company_whatsapp' => preg_replace('/\D/', '', ($data['company_whatsapp'] ?? '')),
                'fonnte_token' => $data['fonnte_token'] ?? null,
                'wa_template_name' => $data['wa_template_name'] ?? null,
                'wa_template_lang' => $data['wa_template_lang'] ?? 'id',
                'hero_heading' => $data['hero_heading'] ?? null,
                'hero_description' => $data['hero_description'] ?? null,
                'services_heading' => $data['services_heading'] ?? null,
                'services_description' => $data['services_description'] ?? null,
                'portfolio_heading' => $data['portfolio_heading'] ?? null,
                'portfolio_description' => $data['portfolio_description'] ?? null,
                'testimonials_heading' => $data['testimonials_heading'] ?? null,
                'testimonials_description' => $data['testimonials_description'] ?? null,
                'contact_cta_title' => $data['contact_cta_title'] ?? null,
                'contact_cta_description' => $data['contact_cta_description'] ?? null,
            ];
            Storage::disk('local')->put('settings_local.json', json_encode($payload));

            // Apply runtime config for current process
            config()->set('app.name', $payload['app_name']);
            config()->set('app.url', $payload['app_url']);
            config()->set('app.locale', $payload['app_locale']);
            config()->set('app.timezone', $payload['app_timezone']);
            config()->set('app.logo', $payload['app_logo']);
            config()->set('app.currency', $payload['app_currency']);
            config()->set('app.date_format', $payload['app_date_format']);
            config()->set('app.company_whatsapp', $payload['company_whatsapp']);
            config()->set('app.whatsapp_number', $payload['company_whatsapp']);
            // Provider tokens (allow jobs to read from config instead of env when local)
            config()->set('services.fonnte.token', $payload['fonnte_token']);
            config()->set('services.whatsapp.template_name', $payload['wa_template_name']);
            config()->set('services.whatsapp.template_lang', $payload['wa_template_lang']);

            return redirect()->route('settings.index')->with('success', 'Settings updated locally without .env write.');
        }
    }

    public function whatsappTest(Request $request)
    {
        $data = $request->validate([
            'wa_number' => 'required|string|max:32',
            'message' => 'nullable|string|max:1000',
            'cta_url' => 'nullable|url|max:500',
        ]);

        try {
            // Run synchronously in local so admin gets immediate feedback
            if (app()->environment('local')) {
                \App\Jobs\SendWhatsAppMessage::dispatchSync(
                    to: $data['wa_number'],
                    message: $data['message'] ?? 'Test WhatsApp from Admin Settings',
                    ctaUrl: $data['cta_url'] ?? null,
                    templateVars: []
                );
            } else {
                \App\Jobs\SendWhatsAppMessage::dispatch(
                    to: $data['wa_number'],
                    message: $data['message'] ?? 'Test WhatsApp from Admin Settings',
                    ctaUrl: $data['cta_url'] ?? null,
                    templateVars: []
                );
            }
            return back()->with('success', 'Test WhatsApp dikirim (cek log bila tidak menerima).');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal mengirim test WhatsApp: '.$e->getMessage());
        }
    }

    private function setEnv(array $pairs): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return; // silently ignore if .env not found
        }

        // Backup existing .env with timestamp
        try {
            $backupPath = base_path('.env.backup-'.date('Ymd_His'));
            @copy($envPath, $backupPath);
        } catch (\Throwable $e) {
            // ignore backup failure
        }

        $env = file_get_contents($envPath) ?: '';

        // Normalize line endings
        $env = str_replace(["\r\n", "\r"], "\n", $env);

        foreach ($pairs as $key => $val) {
            $pattern = "/^".preg_quote($key, '/')."=.*/m";
            $line = $key . '=' . $val;

            // Remove all existing occurrences of the key to avoid duplicates
            while (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, '', $env, 1);
                // Clean up potential blank lines created by removal
                $env = preg_replace("/\n{2,}/", "\n", $env);
            }

            // Ensure newline before appending if not empty and last char not newline
            if ($env !== '' && !str_ends_with($env, "\n")) {
                $env .= "\n";
            }
            $env .= $line . "\n";
        }

        // Ensure file ends with a single newline
        $env = rtrim($env, "\n") . "\n";

        // Write atomically: write to temp then rename
        $tmpPath = $envPath.'.tmp';
        file_put_contents($tmpPath, $env, LOCK_EX);
        @rename($tmpPath, $envPath);
    }

    private function loadLocalSettings(): array
    {
        try {
            if (Storage::disk('local')->exists('settings_local.json')) {
                $raw = Storage::disk('local')->get('settings_local.json');
                $data = json_decode($raw, true);
                return is_array($data) ? $data : [];
            }
        } catch (\Throwable $e) {
            // ignore read errors in local
        }
        return [];
    }
}
