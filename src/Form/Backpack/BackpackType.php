<?php

namespace App\Form\Backpack;

use App\Entity\Backpack;
use App\Entity\Category;
use App\Entity\Process;
use App\Entity\MProcess;
use App\Entity\UnderRubric;
use App\Form\AppTypeAbstract;
use Doctrine\ORM\EntityRepository;
use App\Form\File\BackpackFileType;
use App\Form\File\BackpackLinkType;
use App\Security\CurrentUser;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BackpackType extends AppTypeAbstract
{
    private $user;
    public function __construct(CurrentUser $currentUser)
    {
        $this->user = $currentUser->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildFormName($builder);
        $this->buildFormContent($builder);
        $builder
            ->add('category', EntityType::class, [
                self::CSS_CLASS => Category::class,
                self::CHOICE_LABEL => 'name',
                self::LABEL => 'Type de porte-document',
                self::MULTIPLE => false,
                self::REQUIRED => false,
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->setParameter('val', '1')
                        ->where('c.isEnable=:val')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('mProcess', EntityType::class, [
                self::CSS_CLASS => MProcess::class,
                self::CHOICE_LABEL => 'fullname',
                self::LABEL => 'Macro-processus',
                self::MULTIPLE => false,
                self::REQUIRED => false,
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->orderBy('c.ref', 'ASC')
                        ->addOrderBy('c.name', 'ASC');
                }
            ])
            ->add('process', EntityType::class, [
                self::CSS_CLASS => Process::class,
                self::CHOICE_LABEL => 'fullname',
                self::LABEL => 'Processus',
                self::MULTIPLE => false,
                self::REQUIRED => false,
                self::ATTR => ['disabled' => 'true'],
                self::QUERY_BUILDER => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->orderBy('c.ref', 'ASC')
                        ->addOrderBy('c.name', 'ASC');
                }
            ])
            ->add(
                'updateAt',
                DateTimeType::class,
                [
                    self::LABEL            => 'dater',
                    self::REQUIRED => false
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Backpack::class,
        ]);
    }
}
