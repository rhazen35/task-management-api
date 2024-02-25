<?php

declare(strict_types=1);

namespace App\DataFixtures;

enum FixtureGroup: string
{
    case Development = 'dev';
    case Test = 'test';

    /**
     * @return array<string>
     */
    public static function availableValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
