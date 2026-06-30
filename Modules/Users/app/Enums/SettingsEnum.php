<?php

namespace Modules\Users\Enums;

use App\Traits\Parable;

enum SettingsEnum: string
{
    use Parable;

    case REGISTRATION_OPEN = 'registration_open:checkbox';

    /**
     * Get default value
     */
    public function defaultValue(): mixed
    {
        return match ($this) {
            self::REGISTRATION_OPEN => true,
        };
    }
}