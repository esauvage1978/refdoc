<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\MProcess;
use App\Entity\Organisme;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class AppTypeAbstract extends AbstractType
{
    public const LABEL = 'label';
    public const DATA = 'data';
    public const REQUIRED = 'required';
    public const ROW_ATTR = 'row_attr';
    public const ATTR = 'attr';
    public const CHOICE_LABEL = 'choice_label';
    public const MULTIPLE = 'multiple';
    public const CSS_CLASS = 'class';
    public const ROWS = 'rows';
    public const GROUP_BY = 'group_by';
    public const QUERY_BUILDER = 'query_builder';
    public const DISABLED = 'disabled';
    public const MAXLENGTH = 'maxlength';
    public const PLACEHOLDER = 'placeholder';

    public function buildFormName(FormBuilderInterface $builder): void
    {
        $builder
            ->add('name', TextType::class, [
                self::LABEL => 'Nom',
                self::REQUIRED => true,
                self::ATTR => [self::MAXLENGTH => 255],
            ]);
    }

    public function buildFormIsEnable(FormBuilderInterface $builder): void
    {
        $builder
            ->add(
                'isEnable',
                CheckboxType::class,
                [
                    self::LABEL => ' ',
                    self::REQUIRED => false,
                ]
            );
    }

    public function buildFormContent(FormBuilderInterface $builder): void
    {
        $builder
            ->add('content', TextareaType::class, [
                self::LABEL => 'Description',
                self::REQUIRED => false,
                self::ATTR => [self::ROWS => 3, self::CSS_CLASS => 'textarea'],
            ]);
    }

    public function buildFormOrganismes(FormBuilderInterface $builder): void
    {
        $builder
            ->add('organismes', EntityType::class, [
                'class' => Organisme::class,
                self::CHOICE_LABEL => 'fullname',
                self::MULTIPLE => true,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('o')
                        ->orderBy('o.ref', 'ASC')
                        ->addOrderBy('o.name', 'ASC');
                },
            ]);
    }

    public function buildFormMProcess(FormBuilderInterface $builder): void
    {
        $builder
            ->add('mprocess', EntityType::class, [
                'class' => MProcess::class,
                self::CHOICE_LABEL => 'fullnameSelect',
                self::MULTIPLE => false,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => true,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('o')
                        ->orderBy('o.ref', 'ASC')
                        ->addOrderBy('o.name', 'ASC');
                },
            ]);
    }

    public function buildFormUsers(FormBuilderInterface $builder): void
    {
        $builder
            ->add('users', EntityType::class, [
                'class' => User::class,
                self::LABEL => 'Utilisateurs',
                self::CHOICE_LABEL => 'name',
                self::MULTIPLE => true,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
            ]);
    }

    public function buildFormContributors(FormBuilderInterface $builder): void
    {
        $builder
            ->add('contributors', EntityType::class, [
                'class' => User::class,
                self::LABEL => 'Contributeurs',
                self::CHOICE_LABEL => 'name',
                self::MULTIPLE => true,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
            ]);
    }

    public function buildFormValidators(FormBuilderInterface $builder): void
    {
        $builder
            ->add('validators', EntityType::class, [
                'class' => User::class,
                self::LABEL => 'Valideurs',
                self::CHOICE_LABEL => 'name',
                self::MULTIPLE => true,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.isEnable=:ie')
                        ->setParameter('ie', '1')
                        ->orderBy('u.name', 'ASC');
                },
            ]);
    }

    public function buildFormDirValidators(FormBuilderInterface $builder): void
    {
        $builder
            ->add('dirValidators', EntityType::class, [
                'class' => User::class,
                self::LABEL => 'Valideurs de la Direction',
                self::CHOICE_LABEL => 'name',
                self::MULTIPLE => true,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.isEnable=:ie')
                        ->setParameter('ie', '1')
                        ->orderBy('u.name', 'ASC');
                },
            ]);
    }

    public function buildFormPoleValidators(FormBuilderInterface $builder): void
    {
        $builder
            ->add('poleValidators', EntityType::class, [
                'class' => User::class,
                self::LABEL => 'Valideurs stratégiques',
                self::CHOICE_LABEL => 'name',
                self::MULTIPLE => true,
                self::ATTR => ['class' => 'select2'],
                self::REQUIRED => false,
                self::QUERY_BUILDER => static function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->Where('u.isEnable=:ie')
                        ->setParameter('ie', '1')
                        ->orderBy('u.name', 'ASC');
                },
            ]);
    }
}
