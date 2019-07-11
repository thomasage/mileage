<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Record;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RecordFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var Car $car1 */
        $car1 = $this->getReference('car1');

        $data = [
            ['2017-08-30', 5000, true],
            ['2022-08-30', 135000, true],
            ['2017-09-30', 3929, false],
            ['2017-10-04', 4462, false],
            ['2017-10-05', 4464, false],
            ['2017-10-29', 5613, false],
            ['2017-11-14', 7354, false],
            ['2017-11-18', 7873, false],
        ];

        foreach ($data as $datum) {

            $record = new Record();
            $record
                ->setCar($car1)
                ->setDate(new \DateTime($datum[0]))
                ->setForecast($datum[2])
                ->setValue($datum[1]);

            $manager->persist($record);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CarFixtures::class,
        ];
    }
}
