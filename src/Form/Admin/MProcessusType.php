<?php

namespace App\Form\Admin;

use App\Entity\MProcessus;
use App\Form\AppTypeAbstract;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MProcessusType extends AppTypeAbstract
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildFormName($builder);
        $this->buildFormIsEnable($builder);
        $this->buildFormValidators($builder);
        $this->buildFormContributors($builder);

        $builder
            ->add('ref', TextType::class, [
                self::LABEL => 'Référence',
                self::REQUIRED => true,
                self::ATTR => [self::PLACEHOLDER=>'000']
            ]);
        $builder = $this->buildFormContent($builder);
;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MProcessus::class,
        ]);
    }
}
