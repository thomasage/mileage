<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarDeleteType;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/car")
 */
class CarController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return Response
     *
     * @Route("/add", name="app_car_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        $car = new Car();

        $formEdit = $this->createForm(CarType::class, $car);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $em->persist($car);
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.car_added'));

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
     * @Route("/{car}", name="app_car_edit", methods={"GET", "POST"})
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

            $em->flush();

            $this->addFlash('success', $translator->trans('notification.car_updated'));

            return $this->redirectToRoute('app_car_index');

        }

        $formDelete = $this->createForm(CarDeleteType::class, $car);
        $formDelete->handleRequest($request);

        if ($formDelete->isSubmitted() && $formDelete->isValid()) {

            $em->remove($car);
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.car_removed'));

            return $this->redirectToRoute('app_car_index');

        }

        return $this->render(
            'car/edit.html.twig',
            [
                'car' => $car,
                'formDelete' => $formDelete->createView(),
                'formEdit' => $formEdit->createView(),
            ]
        );
    }

    /**
     * @param CarRepository $carRepository
     * @return Response
     *
     * @Route("/", name="app_car_index", methods={"GET"})
     */
    public function index(CarRepository $carRepository): Response
    {
        $cars = $carRepository->findBy([], ['title' => 'ASC']);

        return $this->render(
            'car/index.html.twig',
            [
                'cars' => $cars,
            ]
        );
    }
}
