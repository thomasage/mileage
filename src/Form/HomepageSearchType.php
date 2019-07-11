<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HomepageSearchType extends AbstractType
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
            );
    }
}
