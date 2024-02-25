<?php

declare(strict_types=1);

namespace App\Model\Factory;

use App\Entity\User;
use App\Model\Gender;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<User>
 *
 * @method        User|Proxy                     create(array|callable $attributes = [])
 * @method static User|Proxy                     createOne(array $attributes = [])
 * @method static User|Proxy                     find(object|array|mixed $criteria)
 * @method static User|Proxy                     findOrCreate(array $attributes)
 * @method static User|Proxy                     first(string $sortedField = 'id')
 * @method static User|Proxy                     last(string $sortedField = 'id')
 * @method static User|Proxy                     random(array $attributes = [])
 * @method static User|Proxy                     randomOrCreate(array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method static User[]|Proxy[]                 all()
 * @method static User[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static User[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static User[]|Proxy[]                 findBy(array $attributes)
 * @method static User[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static User[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    public function __construct(
        #[Autowire(param: 'admin_user.password')]
        private readonly string $adminPassword,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        $gender = self::faker()->randomElement(Gender::availableValues());

        return [
            'email' => self::faker()->companyEmail(),
            'firstName' => self::faker()->firstName($gender),
            'isVerified' => self::faker()->boolean(),
            'lastName' => self::faker()->lastName($gender),
            'plainPassword' => $this->adminPassword,
            'roles' => [],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this->afterInstantiate(
            function (User $user) {
                $plainPassword = $user->getPlainPassword();

                assert(is_string($plainPassword));

                $hashedPassword = $this
                    ->passwordHasher
                    ->hashPassword(
                        $user,
                        $plainPassword,
                    );

                $user->setPassword($hashedPassword);
            });
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
