<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\UserRegistrationHelper;
use App\Service\UserVendorHelper;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserRegistrationHelper $userRegistrationHelper): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('app_user_new')
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try {
                $userRegistrationHelper->setUpUser($user);
                $userRepository->save($user, true);

                return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
            } catch (Exception $e) {

                if ($e->getCode() === 1062) {
                    $this->addFlash('error', "User with Email: {$user->getEmail()} already exists");
                }

                return $this->redirectToRoute('app_user_new', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, UserVendorHelper $userVendorHelper): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('app_user_edit', ['id' => $user->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $userVendorHelper->setUpVendor($user);

            $userRepository->save($user, true);
            
            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }

            return $this->redirectToRoute('app_user_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/_edit_form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/profile-{id}', name: 'app_user_profile', methods: ['GET'])]
    public function show(User $user): Response
    {
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('app_user_edit', ['id' => $user->getId()])
        ]);

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
