<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Record;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class RecordFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        /** @var Car $car1 */
        $car1 = $this->getReference('car1');

        for ($i = 0; $i < 5; $i++) {

            $record = new Record();
            $record
                ->setCar($car1)
                ->setDate($faker->dateTimeBetween(sprintf('-%d weeks', 5 - $i), sprintf('-%d weeks -1 day', 4 - $i)))
                ->setValue($faker->numberBetween($i * 10000, ($i + 1) * 10000 - 1));

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
