<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CarController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return Response
     *
     * @Route("/car/add", name="app_car_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        $car = new Car();

        $formEdit = $this->createForm(CarType::class, $car);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $this->addFlash('success', $translator->trans('notification.car_added'));

            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute('app_car_index');

        }

        return $this->render(
            'car/add.html.twig',
            [
                'formEdit' => $formEdit->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @param Car $car
     * @return Response
     *
     * @Route("/car/{car}", name="app_car_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        Car $car
    ): Response {
        $formEdit = $this->createForm(CarType::class, $car);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $this->addFlash('success', $translator->trans('notification.car_updated'));

            $em->flush();

            return $this->redirectToRoute('app_car_index');

        }

        return $this->render(
            'car/edit.html.twig',
            [
                'car' => $car,
                'formEdit' => $formEdit->createView(),
            ]
        );
    }

    /**
     * @param CarRepository $carRepository
     * @return Response
     *
     * @Route("/car", name="app_car_index", methods={"GET"})
     */
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findAll();

        return $this->render(
            'car/index.html.twig',
            [
                'cars' => $cars,
            ]
        );
    }
}