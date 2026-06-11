<?php

namespace App\Http\Enums;

enum SettingEnum: string
{
    case SITE_NAME = 'site_name:text';
    case SITE_EMAIL = 'site_email:email';
    case SITE_URL = 'site_url:url';
    case SITE_THEME = 'site_theme:select';
    case MAINTENANCE_MODE = 'maintenance_mode:checkbox';
    case ITEMS_PER_PAGE = 'items_per_page:number';

    /**
     * Get the setting name (without type)
     */
    public function name(): string
    {
        return explode(':', $this->value)[0];
    }

    /**
     * Get the field type
     */
    public function fieldType(): string
    {
        $parts = explode(':', $this->value);
        return $parts[1] ?? 'text';
    }

    /**
     * Get the display label
     */
    public function label(): string
    {
        return ucwords(str_replace('_', ' ', $this->name()));
    }

    /**
     * Get options for select fields
     */
    public function options(): array
    {
        return match ($this) {
            self::SITE_THEME => [
                'light' => 'Light',
                'dark' => 'Dark',
                'blue' => 'Blue',
            ],
            default => [],
        };
    }

    /**
     * Get default value
     */
    public function defaultValue(): mixed
    {
        return match ($this) {
            self::SITE_NAME => 'My Website',
            self::SITE_EMAIL => 'admin@example.com',
            self::SITE_URL => 'https://example.com',
            self::SITE_THEME => 'light',
            self::MAINTENANCE_MODE => false,
            self::ITEMS_PER_PAGE => 10,
        };
    }
}
