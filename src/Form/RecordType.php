<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Car;
use App\Entity\Record;
use App\Repository\CarRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'car',
                EntityType::class,
                [
                    'class' => Car::class,
                    'label' => 'field.car',
                    'query_builder' => function (CarRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('car')
                            ->addOrderBy('car.title', 'ASC');
                    },
                    'required' => true,
                ]
            )
            ->add(
                'date',
                DateType::class,
                [
                    'label' => 'field.date',
                    'required' => true,
                    'widget' => 'single_text',
                ]
            )
            ->add(
                'value',
                IntegerType::class,
                [
                    'label' => 'field.mileage',
                    'required' => true,
                ]
            )
            ->add(
                'forecast',
                ChoiceType::class,
                [
                    'choices' => [
                        'true' => true,
                        'false' => false,
                    ],
                    'label' => 'field.forecast',
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Record::class,
            ]
        );
    }
}
