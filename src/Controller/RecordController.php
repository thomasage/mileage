<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecordController extends AbstractController
{
    /**
     * @param RecordRepository $recordRepository
     * @return Response
     *
     * @Route("/record", name="app_record_index", methods={"GET"})
     */
    public function index(RecordRepository $recordRepository): Response
    {
        $records = $recordRepository->findAll();

        return $this->render(
            'record/index.html.twig',
            [
                'records' => $records,
            ]
        );
    }
}
