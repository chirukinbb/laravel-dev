<?php

namespace App\Traits;

trait Parable
{

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
}