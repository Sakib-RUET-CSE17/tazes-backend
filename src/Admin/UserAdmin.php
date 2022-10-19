<?php

declare(strict_types=1);

namespace App\Admin;

use App\Enum\RoleTypeEnum;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

final class UserAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('id')
            ->add('roll')
            ->add('email')
            ->add('mobile')
            ->add('type')
            ->add('passwordUpdatedAt')
            ->add('isVerified')
            ->add('bookLends')
            ->add('bookReturns');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('roll')
            ->add('email')
            ->add('mobile')
            ->add('type', 'enum')
            ->add('roles')
            ->add('passwordUpdatedAt')
            ->add('isVerified')
            ->add('bookLends')
            ->add('bookReturns')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('roll')
            ->add('email')
            ->add('mobile')
            ->add('plainPassword')
            ->add('type', EnumType::class, [
                'class' => RoleTypeEnum::class,
            ])
            ->add('isVerified');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('roll')
            ->add('email')
            ->add('mobile')
            ->add('type', 'enum')
            ->add('roles')
            ->add('isVerified')
            ->add('passwordUpdatedAt')
            ->add('bookLends')
            ->add('bookReturns');
    }
}
