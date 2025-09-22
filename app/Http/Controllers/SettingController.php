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