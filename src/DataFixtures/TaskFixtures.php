<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Factory\TaskFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return FixtureGroup::availableValues();
    }

    /**
     * @return array<string>
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        TaskFactory::createMany(30);

        $manager->flush();
    }
}
