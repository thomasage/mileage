<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserAddType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add(
                'password',
                RepeatedType::class,
                [
                    'first_options' => [
                        'label' => 'field.password',
                    ],
                    'mapped' => false,
                    'required' => true,
                    'second_options' => [
                        'label' => 'field.confirmation',
                    ],
                    'type' => PasswordType::class,
                ]
            );
    }
}
