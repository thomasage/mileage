<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Record;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RecordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Record::class);
    }

    public function findChartData(Car $car): array
    {
        $series = [['data' => []]];

        if (null !== $car->getRentalStartedAt()
            && null !== $car->getRentalStartedMileage()
            && null !== $car->getRentalEndedAt()
            && null !== $car->getRentalEndedMileage()) {
            $series[1] = [
                'data' => [
                    $car->getRentalStartedAt()->format('Y-m-d') => $car->getRentalStartedMileage(),
                    $car->getRentalEndedAt()->format('Y-m-d') => $car->getRentalEndedMileage(),
                ],
            ];
        }

        $builder = $this->createQueryBuilder('record')
            ->andWhere('record.car = :car')
            ->setParameter('car', $car)
            ->addOrderBy('record.date', 'ASC');

        /** @var Record $r */
        foreach ($builder->getQuery()->getResult() as $r) {
            $series[0]['data'][$r->getDate()->format('Y-m-d')] = $r->getValue();
        }

        return $series;
    }
}
