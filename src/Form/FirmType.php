<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Firm;
use App\Entity\LegalForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add(
                'legalForm',
                EntityType::class,
                [
                    'required' => true,
                    'class' => LegalForm::class,
                    'label' => 'firm.form.legal-form',
                    'placeholder' => 'firm.form.legal-form.placeholder',
                ]
            )
            ->add('name', null, ['label' => 'firm.form.name'])
            ->add('siren', null, ['label' => 'firm.form.siren'])
            ->add('registerCity', null, ['label' => 'firm.form.registerCity'])
            ->add(
                'dateRegister',
                DateTimeType::class,
                [
                    'label' => 'firm.form.dateRegister',
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => ['class' => 'air-datepicker', 'data-date-format' => 'dd-mm-yyyy'],
                ]
            )
            ->add('capital', null, ['label' => 'firm.form.capital'])
            ->add(
                'address',
                CollectionType::class,
                [
                    'label' => 'firm.form.address',
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
