<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserAddType;
use App\Form\UserDeleteType;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     *
     * @Route("/add", name="app_user_add", methods={"GET", "POST"})
     */
    public function add(
        Request $request,
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $user = new User();

        $formEdit = $this->createForm(UserAddType::class, $user);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $user->setPassword($passwordEncoder->encodePassword($user, $formEdit->get('password')->getData()));

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.user_added'));

            return $this->redirectToRoute('app_user_index');

        }

        return $this->render(
            'user/add.html.twig',
            [
                'formEdit' => $formEdit->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepository $userRepository
     * @param User $user
     * @return Response
     *
     * @Route("/{user}", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        TranslatorInterface $translator,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository,
        User $user
    ): Response {

        $countUsers = count($userRepository->findAll());

        $formEdit = $this->createForm(UserType::class, $user);
        $formEdit->handleRequest($request);

        if ($formEdit->isSubmitted() && $formEdit->isValid()) {

            $em->flush();

            $this->addFlash('success', $translator->trans('notification.user_updated'));

            return $this->redirectToRoute('app_user_index');

        }

        $formPassword = $this->createForm(UserPasswordType::class);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {

            $user->setPassword($passwordEncoder->encodePassword($user, $formPassword->get('password')->getData()));
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.user_password_updated'));

            return $this->redirectToRoute('app_user_index');

        }

        $formDelete = $this->createForm(UserDeleteType::class, $user);
        $formDelete->handleRequest($request);

        if ($formDelete->isSubmitted() && $formDelete->isValid()) {

            if (1 === $countUsers) {

                $this->addFlash('success', $translator->trans('notification.only_one_user_left'));

                return $this->redirectToRoute('app_user_index');

            }

            $em->remove($user);
            $em->flush();

            $this->addFlash('success', $translator->trans('notification.user_removed'));

            return $this->redirectToRoute('app_user_index');

        }

        return $this->render(
            'user/edit.html.twig',
            [
                'countUsers' => $countUsers,
                'formDelete' => $formDelete->createView(),
                'formEdit' => $formEdit->createView(),
                'formPassword' => $formPassword->createView(),
                'user' => $user,
            ]
        );
    }

    /**
     * @param UserRepository $userRepository
     * @return Response
     *
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['username' => 'ASC']);

        return $this->render(
            'user/index.html.twig',
            [
                'users' => $users,
            ]
        );
    }
}
