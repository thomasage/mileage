<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Record;
use App\Form\RecordDeleteType;
use App\Form\RecordType;
use App\Repository\RecordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/record")
 */
class RecordController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @return Response
     *
     * @Route("/add", name="app_record_add", methods={"GET", "POST"})
     */
    public function add(Request $request, EntityManagerInterface $em, TranslatorInterface $translator): Response
    {
        $record = new Record();

        $formEdit = $this->createForm(RecordType::class, $record);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $em->persist($record);
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.record_added'));

            return $this->redirectToRoute('app_record_index');

        }

        return $this->render(
            'record/add.html.twig',
            [
                'formEdit' => $formEdit->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @param Record $record
     * @return Response
     *
     * @Route("/{record}", name="app_record_edit", methods={"GET", "POST"}, requirements={"record"="\d+"})
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        Record $record
    ): Response {
        $formEdit = $this->createForm(RecordType::class, $record);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $em->flush();

            $this->addFlash('success', $translator->trans('notification.record_updated'));

            return $this->redirectToRoute('app_record_index');

        }

        $formDelete = $this->createForm(RecordDeleteType::class, $record);
        $formDelete->handleRequest($request);

        if ($formDelete->isSubmitted() && $formDelete->isValid()) {

            $em->remove($record);
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.record_removed'));

            return $this->redirectToRoute('app_record_index');

        }

        return $this->render(
            'record/edit.html.twig',
            [
                'formDelete' => $formDelete->createView(),
                'formEdit' => $formEdit->createView(),
                'record' => $record,
            ]
        );
    }

    /**
     * @param Request $request
     * @param RecordRepository $recordRepository
     * @return Response
     *
     * @Route("/", name="app_record_index", methods={"GET"})
     */
    public function index(Request $request, RecordRepository $recordRepository): Response
    {
        $records = $recordRepository->findBySearch((int)$request->get('page', 0));

        return $this->render(
            'record/index.html.twig',
            [
                'records' => $records,
            ]
        );
    }
}
