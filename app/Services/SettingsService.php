<?php

namespace App\Services;

use App\Http\Enums\SettingEnum;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Get a setting value by enum key
     */
    public function get(SettingEnum $key, mixed $default = null): mixed
    {
        $setting = Setting::where('name', $key->name())->first();

        if ($setting === null) {
            return $default;
        }

        return $setting->value;
    }

    /**
     * Set a setting value by enum key
     */
    public function set(SettingEnum $key, mixed $value): Setting
    {
        $setting = Setting::updateOrCreate(
            ['name' => $key->name()],
            ['value' => $value]
        );

        return $setting;
    }

    /**
     * Get all settings as key-value pairs
     */
    public function getAll(): array
    {
        return Setting::pluck('value', 'name')->toArray();
    }

    /**
     * Delete a setting by enum key
     */
    public function delete(SettingEnum $key): bool
    {
        return Setting::where('name', $key->name())->delete() > 0;
    }

    /**
     * Get setting with caching
     */
    public function getWithCache(SettingEnum $key, mixed $default = null): mixed
    {
        $cacheKey = 'setting_' . $key->name();

        return Cache::remember($cacheKey, now()->addHours(1), function () use ($key, $default) {
            return $this->get($key, $default);
        });
    }

    /**
     * Clear cache for a specific setting
     */
    public function clearCache(SettingEnum $key): void
    {
        Cache::forget('setting_' . $key->name());
    }

    /**
     * Clear all settings cache
     */
    public function clearAllCache(): void
    {
        Setting::all()->each(function ($setting) {
            Cache::forget('setting_' . $setting->name);
        });
    }
}
