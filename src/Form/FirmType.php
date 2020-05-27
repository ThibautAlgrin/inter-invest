<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Firm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FirmType.
 */
class FirmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('siren')
            ->add('registerCity')
            ->add(
                'dateRegister',
                DateTimeType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => ['class' => 'air-datepicker', 'data-date-format' => 'dd-mm-yyyy'],
                ]
            )
            ->add('capital')
            ->add(
                'address',
                CollectionType::class,
                [
                    'entry_type' => AddressType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Firm::class,
        ]);
    }
}
