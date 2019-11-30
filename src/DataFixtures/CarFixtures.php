<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $car = new Car();
        $car
            ->setRentalStartedAt(new \DateTime('2017-09-30'))
            ->setRentalStartedMileage(5000)
            ->setRentalEndedAt(new \DateTime('2022-09-30'))
            ->setRentalEndedMileage(135000)
            ->setTitle(ucfirst($faker->word));

        $manager->persist($car);

        $this->setReference('car1', $car);

        $manager->flush();
    }
}
