<?php

declare(strict_types=1);

namespace App\Model;

enum Gender: string
{
    case Female = 'female';
    case Male = 'male';

    /**
     * @return array<string>
     */
    public static function availableValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
