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
            ['2017-11-22', 8209, false],
            ['2017-12-01', 9382, false],
            ['2017-12-14', 11065, false],
            ['2017-12-15', 11147, false],
            ['2018-01-21', 15591, false],
            ['2018-01-23', 15845, false],
            ['2018-01-28', 16487, false],
            ['2018-01-29', 16756, false],
            ['2018-01-30', 16934, false],
            ['2018-01-31', 17113, false],
            ['2018-02-01', 17285, false],
            ['2018-02-15', 18979, false],
            ['2018-02-19', 19524, false],
            ['2018-02-21', 19701, false],
            ['2018-03-02', 20113, false],
            ['2018-03-05', 20409, false],
            ['2018-03-15', 21647, false],
            ['2018-03-16', 21728, false],
            ['2018-03-17', 21878, false],
            ['2018-03-30', 22865, false],
            ['2018-04-02', 23146, false],
            ['2018-04-04', 23325, false],
            ['2018-04-05', 23410, false],
            ['2018-04-07', 23745, false],
            ['2018-04-08', 23855, false],
            ['2018-04-10', 23936, false],
            ['2018-04-11', 24049, false],
            ['2018-04-18', 26075, false],
            ['2018-04-20', 26156, false],
            ['2018-04-23', 26252, false],
            ['2018-04-29', 26701, false],
            ['2018-05-03', 26704, false],
            ['2018-05-05', 26714, false],
            ['2018-05-08', 27009, false],
            ['2018-05-22', 27009, false],
            ['2018-05-26', 27308, false],
            ['2018-05-30', 27537, false],
            ['2018-06-01', 27633, false],
            ['2018-06-03', 27824, false],
            ['2018-06-06', 28131, false],
            ['2018-06-08', 28307, false],
            ['2018-06-09', 28469, false],
            ['2018-06-11', 28751, false],
            ['2018-06-13', 28906, false],
            ['2018-06-14', 28987, false],
            ['2018-06-17', 29468, false],
            ['2018-06-19', 29553, false],
            ['2018-06-20', 29635, false],
            ['2018-06-23', 29848, false],
            ['2018-06-25', 29959, false],
            ['2018-06-27', 30031, false],
            ['2018-06-29', 30126, false],
            ['2018-07-10', 30710, false],
            ['2018-07-17', 31026, false],
            ['2018-07-18', 31263, false],
            ['2018-07-24', 31558, false],
            ['2018-07-25', 31568, false],
            ['2018-07-26', 31649, false],
            ['2018-08-01', 31924, false],
            ['2018-08-07', 32104, false],
            ['2018-08-10', 32277, false],
            ['2018-08-17', 32369, false],
            ['2018-08-31', 32461, false],
            ['2018-09-02', 32646, false],
            ['2018-09-08', 32750, false],
            ['2018-09-20', 33024, false],
            ['2018-09-29', 33042, false],
            ['2018-09-30', 33116, false],
            ['2018-11-04', 36148, false],
            ['2018-11-03', 36041, false],
            ['2018-10-21', 33774, false],
            ['2018-10-18', 33585, false],
            ['2018-11-14', 36508, false],
            ['2018-11-09', 36304, false],
            ['2018-11-07', 36220, false],
            ['2018-11-23', 36778, false],
            ['2018-12-02', 37067, false],
            ['2019-01-10', 38487, false],
            ['2019-01-11', 38569, false],
            ['2019-01-16', 38932, false],
            ['2019-01-28', 39457, false],
            ['2019-03-01', 41619, false],
            ['2019-02-28', 41536, false],
            ['2019-03-17', 43402, false],
            ['2019-03-15', 43143, false],
            ['2019-03-13', 42964, false],
            ['2019-03-11', 42796, false],
            ['2019-03-10', 42722, false],
            ['2019-03-04', 41997, false],
            ['2019-03-22', 43749, false],
            ['2019-03-23', 43955, false],
            ['2019-03-25', 44172, false],
            ['2019-04-11', 45691, false],
            ['2019-04-14', 45973, false],
            ['2019-04-21', 46479, false],
            ['2019-05-06', 47785, false],
            ['2019-05-10', 48224, false],
            ['2019-05-13', 48645, false],
            ['2019-05-22', 49451, false],
            ['2019-05-17', 48992, false],
            ['2019-05-23', 49451, false],
            ['2019-06-01', 50171, false],
            ['2019-06-03', 50534, false],
            ['2019-06-05', 50625, false],
            ['2019-06-07', 50815, false],
            ['2019-06-28', 52562, false],
            ['2019-07-07', 53080, false],
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
