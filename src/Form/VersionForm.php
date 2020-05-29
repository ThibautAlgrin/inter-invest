<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersionForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'method' => 'GET',
            'attr' => ['class' => 'select2'],
        ]);
    }

    public function getBlockPrefix()
    {
        return 'version';
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
