<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Model\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        #[Autowire(param: 'admin_user.email')]
        private readonly string $adminEmail,
    ) {
    }

    /**
     * @return array<string>
     */
    public static function getGroups(): array
    {
        return FixtureGroup::availableValues();
    }

    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(10);

        $admin = UserFactory::createOne(
            [
                'email' => $this->adminEmail,
            ],
        );

        assert($admin instanceof User);

        $admin->markAsAdmin();
        $manager->flush();
    }
}
