<?php

declare(strict_types=1);

namespace App\Model\Factory;

use App\Entity\Task;
use App\Model\Task\TaskStatus;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Task>
 *
 * @method        Task|Proxy                     create(array|callable $attributes = [])
 * @method static Task|Proxy                     createOne(array $attributes = [])
 * @method static Task|Proxy                     find(object|array|mixed $criteria)
 * @method static Task|Proxy                     findOrCreate(array $attributes)
 * @method static Task|Proxy                     first(string $sortedField = 'id')
 * @method static Task|Proxy                     last(string $sortedField = 'id')
 * @method static Task|Proxy                     random(array $attributes = [])
 * @method static Task|Proxy                     randomOrCreate(array $attributes = [])
 * @method static TaskRepository|RepositoryProxy repository()
 * @method static Task[]|Proxy[]                 all()
 * @method static Task[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Task[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Task[]|Proxy[]                 findBy(array $attributes)
 * @method static Task[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Task[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Task> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Task> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Task> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Task> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Task> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Task> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Task> random(array $attributes = [])
 * @phpstan-method static Proxy<Task> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Task> repository()
 * @phpstan-method static list<Proxy<Task>> all()
 */
final class TaskFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function getDefaults(): array
    {
        return [
            'status' => self::faker()->randomElement(TaskStatus::available()),
            'title' => self::faker()->text(125),
            'description' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        $users = $this
            ->userRepository
            ->findAll();

        return $this
            ->afterInstantiate(
                function (Task $task) use ($users): void {
                    $assignee = $users[array_rand($users)];

                    $task->setAssignee($assignee);
                });
    }

    protected static function getClass(): string
    {
        return Task::class;
    }
}
