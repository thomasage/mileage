<?php
declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'password',
                RepeatedType::class,
                [
                    'first_options' => [
                        'label' => 'field.password',
                    ],
                    'required' => true,
                    'second_options' => [
                        'label' => 'field.confirmation',
                    ],
                    'type' => PasswordType::class,
                ]
            );
    }
}
