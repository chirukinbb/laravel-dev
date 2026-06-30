<?php

namespace App\Http\Controllers;

use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private SettingsService $settings;

    public function __construct(SettingsService $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Display settings page
     */
    public function index()
    {
        $settings = [];

        // Loop through all enum cases and get their values
        foreach ($this->settings->getSettingUnits() as $case) {
            $settings[$case->name()] = $this->settings->get($case, $case->defaultValue());
        }

        return view('settings.index', [
            'settings' => $settings,
            'settingEnum' => $this->settings->getSettingUnits(),
        ]);
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_email' => 'nullable|email|max:255',
            'site_url' => 'nullable|url|max:255',
            'site_theme' => 'nullable|string|in:light,dark,blue',
            'maintenance_mode' => 'nullable|boolean',
            'items_per_page' => 'nullable|integer|min:1|max:100',
        ]);

        // Update each setting
        foreach ($this->settings->getSettingUnits() as $case) {
            if ($case->fieldType() === 'checkbox') {
                // Checkbox: only present if checked
                $value = $request->has($case->name());
            } else {
                $value = $request->input($case->name());
            }

            $this->settings->set($case, $value);
        }

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
