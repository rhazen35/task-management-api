<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Entity\User;
use App\Model\Task\TaskStatus;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TaskCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Task::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            ChoiceField::new('status')
                ->setChoices(TaskStatus::available())
                ->renderAsBadges(),
            AssociationField::new('assignee')
                ->formatValue(
                    fn ($value, $entity) => $value->getFullName(),
                )
                ->setPermission('ROLE_ADMIN'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_ADMIN');
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters,
    ): QueryBuilder {
        $user = $this->getUser();

        assert($user instanceof User);

        $queryBuilder = parent::createIndexQueryBuilder(
            $searchDto,
            $entityDto,
            $fields,
            $filters,
        );

        if ($user->isAdmin()) {
            return $queryBuilder;
        }

        $userId = $user
            ->getId()
            ->toBinary();

        return $queryBuilder
            ->andWhere(
                $queryBuilder
                    ->expr()
                    ->eq(
                        'entity.assignee',
                        ':assignee',
                    ),
            )
            ->setParameter('assignee', $userId);
    }
}
