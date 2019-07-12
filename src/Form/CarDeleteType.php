<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarDeleteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'confirmation',
                CheckboxType::class,
                [
                    'label' => 'confirmation.delete_car',
                    'mapped' => false,
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Car::class,
            ]
        );
    }
}
