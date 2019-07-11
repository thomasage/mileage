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
        $series = [
            ['data' => []],
            ['data' => []],
        ];

        $builder = $this->createQueryBuilder('record')
            ->andWhere('record.car = :car')
            ->setParameter('car', $car)
            ->addOrderBy('record.date', 'ASC');

        /** @var Record $r */
        foreach ($builder->getQuery()->getResult() as $r) {
            $series[$r->getForecast() ? 1 : 0]['data'][$r->getDate()->getTimestamp() * 1000] = $r->getValue();
        }

        return $series;
    }
}
