<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Record;
use App\Repository\CarRepository;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @param CarRepository $carRepository
     * @param Car $car
     * @return Response
     *
     * @Route("/{car}",
     *     name="app_homepage",
     *     methods={"GET"},
     *     requirements={"car"="\d+"},
     *     defaults={"car"="0"})
     */
    public function index(CarRepository $carRepository, ?Car $car): Response
    {
        /** @var Car[] $cars */
        $cars = $carRepository->findBy([], ['title' => 'ASC']);

        if (!$car && count($cars) > 0) {
            return $this->redirectToRoute('app_homepage', ['car' => $cars[0]->getId()]);
        }

        /** @var Record[] $records */
        $records = $car->getRecords()->toArray();
        $lastRecord = array_pop($records);
        if ($lastRecord) {
            $progress = [
                'actual' => $lastRecord->getValue(),
                'date' => $lastRecord->getDate(),
                'supposed' => $car->getSupposedMileageAt($lastRecord->getDate()),
            ];
            $progress['ratio'] = round($progress['actual'] / $progress['supposed'] * 100, 2);
        } else {
            $progress = null;
        }

        return $this->render(
            'default/index.html.twig',
            [
                'car' => $car,
                'cars' => $cars,
                'progress' => $progress,
            ]
        );
    }

    /**
     * @param RecordRepository $recordRepository
     * @param Car $car
     * @return JsonResponse
     *
     * @Route("/records/{car}", name="app_load_records", methods={"GET"}, requirements={"car":"\d+"})
     */
    public function loadRecords(RecordRepository $recordRepository, Car $car): JsonResponse
    {
        $data = $recordRepository->findChartData($car);

        return new JsonResponse($data);
    }
}
