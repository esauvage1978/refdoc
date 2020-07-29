<?php

namespace App\Form\Admin;

use App\Entity\GPI;
use App\Entity\Organisme;
use App\Form\AppTypeAbstract;
use App\GPI\GPIPage;
use App\GPI\GPIShowType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class GPIType extends AppTypeAbstract
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildFormName($builder);
        $this->buildFormContent($builder);
        $this->buildFormIsEnable($builder);

        $builder
            ->add('page', ChoiceType::class, [
                'choices' => GPIPage::getDatas(),
                self::LABEL => 'Page de destination',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => GPIShowType::getDatas(),
                self::LABEL => 'Visuel',
            ])
            ->add(
                'showDate',
                CheckboxType::class,
                [
                    self::LABEL => ' ',
                    self::REQUIRED => false,
                ]
            );
;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GPI::class,
        ]);
    }
}
