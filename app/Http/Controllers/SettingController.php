<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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

        $this->setEnv([
            'APP_NAME' => '"' . $data['app_name'] . '"',
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'] ?? '',
            'APP_URL' => $data['app_url'],
            'APP_LOCALE' => $data['app_locale'],
            'APP_TIMEZONE' => $data['app_timezone'],
            'APP_LOGO' => $data['app_logo'] ?? '',
            'APP_CURRENCY' => $data['app_currency'] ?? 'USD',
            'APP_DATE_FORMAT' => $data['app_date_format'] ?? 'Y-m-d',
            // front texts & whatsapp
            'COMPANY_WHATSAPP' => preg_replace('/\D/', '', ($data['company_whatsapp'] ?? '')),
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
            // ignore in case artisan not available in some contexts
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully');
    }

    private function setEnv(array $pairs): void
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return; // silently ignore if .env not found
        }
        $env = file_get_contents($envPath);
        foreach ($pairs as $key => $val) {
            $pattern = "/^{$key}=.*$/m";
            $line = $key . '=' . $val;
            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $line, $env);
            } else {
                $env .= PHP_EOL . $line;
            }
        }
        file_put_contents($envPath, $env);
    }
}