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
            ->add('email')
            ->add('type')
            ->add('passwordUpdatedAt')
            ->add('isVerified');
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('id')
            ->add('email')
            ->add('type', 'enum')
            ->add('roles')
            ->add('passwordUpdatedAt')
            ->add('isVerified')
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
            ->add('email')
            ->add('plainPassword')
            ->add('type', EnumType::class,[
                'class' => RoleTypeEnum::class,
            ])
            ->add('isVerified');
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('id')
            ->add('email')
            ->add('type', 'enum')
            ->add('roles')
            ->add('isVerified')
            ->add('passwordUpdatedAt')
            ;
    }
}
